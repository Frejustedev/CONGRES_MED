<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreRegistrationRequest;
use App\Models\Event;
use App\Models\Participant;
use App\Models\PromoCode;
use App\Models\Registration;
use App\Models\RegistrationCategory;
use App\Mail\RegistrationConfirmed;
use App\Services\Registrations\PricingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class RegistrationController extends Controller
{
    public function __construct(protected PricingService $pricing)
    {
    }

    public function index(): Response|RedirectResponse
    {
        $event = Event::query()->where('is_active', true)->first();

        if (! $event || ! $event->isRegistrationOpen()) {
            return redirect()
                ->route('home')
                ->with('warning', 'Les inscriptions ne sont pas ouvertes pour le moment.');
        }

        $categories = RegistrationCategory::query()
            ->where('is_active', true)
            ->where('is_public', true)
            ->orderBy('display_order')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'slug' => $c->slug,
                'name' => $c->name,
                'description' => $c->description,
                'current_price' => $c->currentPrice(),
                'current_tier' => $c->currentTier(),
                'currency' => $c->currency,
                'requires_proof' => $c->requires_proof,
            ]);

        return Inertia::render('Public/Registration/Wizard', [
            'event' => [
                'name' => $event->name,
                'starts_at' => $event->starts_at?->toIso8601String(),
                'ends_at' => $event->ends_at?->toIso8601String(),
                'venue_city' => $event->venue_city,
            ],
            'categories' => $categories,
            'countries' => $this->countries(),
        ]);
    }

    public function checkPromo(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:registration_categories,id'],
            'code' => ['nullable', 'string', 'max:64'],
        ]);

        $category = RegistrationCategory::findOrFail($validated['category_id']);
        $pricing = $this->pricing->calculate($category, $validated['code'] ?? null);

        return response()->json($pricing);
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $category = RegistrationCategory::findOrFail($validated['category_id']);
        $pricing = $this->pricing->calculate($category, $validated['promo_code'] ?? null);

        $registration = DB::transaction(function () use ($validated, $category, $pricing) {
            // Créer le participant (sans user_id, il pourra créer son compte plus tard)
            $participant = Participant::create([
                'salutation' => $validated['salutation'] ?? null,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'whatsapp' => $validated['whatsapp'] ?? null,
                'profession' => $validated['profession'] ?? null,
                'organization' => $validated['organization'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'specialty' => $validated['specialty'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'country_of_origin' => $validated['country_of_origin'] ?? null,
                'dietary_restrictions' => $validated['dietary_restrictions'] ?? null,
                'newsletter_optin' => $validated['newsletter_optin'] ?? false,
                'directory_optin' => $validated['directory_optin'] ?? false,
                'preferred_locale' => app()->getLocale(),
            ]);

            // PromoCode (incrémenter le compteur d'usage si valide)
            $promoCodeId = null;
            if ($pricing['promo_valid'] && ! empty($validated['promo_code'])) {
                $promo = PromoCode::where('code', $validated['promo_code'])->first();
                if ($promo) {
                    $promo->increment('current_uses');
                    $promoCodeId = $promo->id;
                }
            }

            // Référence unique
            $reference = sprintf('CONG-%s-%05d', now()->format('Y'), Registration::query()->count() + 1);

            return Registration::create([
                'reference' => $reference,
                'participant_id' => $participant->id,
                'category_id' => $category->id,
                'promo_code_id' => $promoCodeId,
                'amount_due' => $pricing['base'],
                'amount_discount' => $pricing['discount'],
                'amount_paid' => 0,
                'currency' => $pricing['currency'],
                'pricing_tier' => $pricing['tier'],
                'status' => $pricing['total'] > 0 ? 'awaiting_payment' : 'confirmed',
                'source' => 'online',
                'qr_token' => Str::random(48),
                'visa_letter_requested' => $validated['visa_letter_requested'] ?? false,
                'accompanying_persons' => $validated['accompanying_persons'] ?? 0,
                'submitted_at' => now(),
                'confirmed_at' => $pricing['total'] > 0 ? null : now(),
                'ip_address' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 240),
            ]);
        });

        // Email de confirmation
        try {
            Mail::send(new RegistrationConfirmed($registration));
        } catch (\Throwable $e) {
            logger()->warning('Email registration-confirmed failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('registration.confirmation', $registration->reference);
    }

    public function confirmation(string $reference): Response|RedirectResponse
    {
        $registration = Registration::with(['participant', 'category', 'promoCode'])
            ->where('reference', $reference)
            ->firstOrFail();

        return Inertia::render('Public/Registration/Confirmation', [
            'registration' => [
                'reference' => $registration->reference,
                'status' => $registration->status,
                'amount_due' => (float) $registration->amount_due,
                'amount_discount' => (float) $registration->amount_discount,
                'amount_paid' => (float) $registration->amount_paid,
                'remaining' => $registration->remainingAmount(),
                'currency' => $registration->currency,
                'pricing_tier' => $registration->pricing_tier,
                'submitted_at' => $registration->submitted_at?->toIso8601String(),
            ],
            'participant' => [
                'full_name' => $registration->participant->fullName(),
                'email' => $registration->participant->email,
            ],
            'category' => [
                'name' => $registration->category->name,
            ],
            'promoCode' => $registration->promoCode ? [
                'code' => $registration->promoCode->code,
                'label' => $registration->promoCode->label,
            ] : null,
        ]);
    }

    /**
     * Liste minimale ISO 3166-1 alpha-2 (à étoffer si besoin).
     */
    protected function countries(): array
    {
        return [
            ['code' => 'BJ', 'name' => 'Bénin'],
            ['code' => 'BF', 'name' => 'Burkina Faso'],
            ['code' => 'CI', 'name' => "Côte d'Ivoire"],
            ['code' => 'GH', 'name' => 'Ghana'],
            ['code' => 'GN', 'name' => 'Guinée'],
            ['code' => 'ML', 'name' => 'Mali'],
            ['code' => 'NE', 'name' => 'Niger'],
            ['code' => 'NG', 'name' => 'Nigéria'],
            ['code' => 'SN', 'name' => 'Sénégal'],
            ['code' => 'TG', 'name' => 'Togo'],
            ['code' => 'CM', 'name' => 'Cameroun'],
            ['code' => 'GA', 'name' => 'Gabon'],
            ['code' => 'CD', 'name' => 'RD Congo'],
            ['code' => 'MA', 'name' => 'Maroc'],
            ['code' => 'TN', 'name' => 'Tunisie'],
            ['code' => 'DZ', 'name' => 'Algérie'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'BE', 'name' => 'Belgique'],
            ['code' => 'CH', 'name' => 'Suisse'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'US', 'name' => 'États-Unis'],
            ['code' => 'GB', 'name' => 'Royaume-Uni'],
            ['code' => 'DE', 'name' => 'Allemagne'],
            ['code' => 'ES', 'name' => 'Espagne'],
            ['code' => 'IT', 'name' => 'Italie'],
            ['code' => 'PT', 'name' => 'Portugal'],
        ];
    }
}

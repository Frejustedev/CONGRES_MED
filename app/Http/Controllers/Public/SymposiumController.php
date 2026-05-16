<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Symposium;
use App\Models\SymposiumRegistration;
use App\Settings\ModulesSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SymposiumController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        if (! app(ModulesSettings::class)->symposiums_enabled) {
            return redirect()->route('home');
        }

        $symposiums = Symposium::with('sponsor', 'room')
            ->where('is_published', true)
            ->orderBy('starts_at')
            ->get()
            ->map(fn ($s) => $this->serialize($s));

        return Inertia::render('Public/Symposiums/Index', [
            'symposiums' => $symposiums,
        ]);
    }

    public function show(string $slug): Response
    {
        $symposium = Symposium::with('sponsor', 'room')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return Inertia::render('Public/Symposiums/Show', [
            'symposium' => $this->serialize($symposium, true),
        ]);
    }

    public function register(Request $request, string $slug): RedirectResponse
    {
        $symposium = Symposium::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $validated = $request->validate([
            'registration_reference' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $registration = Registration::with('participant')
            ->where('reference', $validated['registration_reference'])
            ->whereHas('participant', fn ($q) => $q->where('email', $validated['email']))
            ->first();

        if (! $registration) {
            return back()->withErrors(['registration_reference' => 'Inscription introuvable. Vérifiez votre référence et e-mail.'])->withInput();
        }

        if ($symposium->capacity && $symposium->registered_count >= $symposium->capacity) {
            return back()->withErrors(['registration_reference' => 'Ce symposium est complet.']);
        }

        $existing = SymposiumRegistration::where('symposium_id', $symposium->id)
            ->where('registration_id', $registration->id)
            ->first();

        if ($existing) {
            return redirect()->route('symposiums.show', $slug)
                ->with('warning', 'Vous êtes déjà inscrit à ce symposium.');
        }

        SymposiumRegistration::create([
            'symposium_id' => $symposium->id,
            'registration_id' => $registration->id,
            'status' => $symposium->price > 0 ? 'pending' : 'paid',
            'amount_paid' => $symposium->price > 0 ? 0 : $symposium->price,
            'currency' => $symposium->currency,
        ]);

        $symposium->increment('registered_count');

        return redirect()->route('symposiums.show', $slug)
            ->with('success', 'Inscription au symposium enregistrée. '.($symposium->price > 0 ? 'Le paiement vous sera demandé sur place.' : 'À très bientôt !'));
    }

    protected function serialize(Symposium $s, bool $full = false): array
    {
        $data = [
            'id' => $s->id,
            'slug' => $s->slug,
            'title' => $s->title,
            'subtitle' => $s->subtitle,
            'starts_at' => $s->starts_at->toIso8601String(),
            'ends_at' => $s->ends_at->toIso8601String(),
            'price' => (float) $s->price,
            'currency' => $s->currency,
            'capacity' => $s->capacity,
            'registered_count' => $s->registered_count,
            'is_full' => $s->capacity && $s->registered_count >= $s->capacity,
            'requires_separate_registration' => $s->requires_separate_registration,
            'cover_image_path' => $s->cover_image_path,
            'sponsor' => $s->sponsor ? [
                'name' => $s->sponsor->name,
                'logo_path' => $s->sponsor->logo_path,
                'website' => $s->sponsor->website,
            ] : null,
            'room' => $s->room ? ['name' => $s->room->name, 'color' => $s->room->color] : null,
        ];
        if ($full) {
            $data['description'] = $s->description;
            $data['speakers_data'] = $s->speakers_data;
        }
        return $data;
    }
}

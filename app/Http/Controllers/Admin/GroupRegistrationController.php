<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupRegistration;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\RegistrationCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class GroupRegistrationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Groups/Index', [
            'groups' => GroupRegistration::withCount('registrations')->latest()->paginate(20),
            'categories' => RegistrationCategory::where('is_active', true)->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:200'],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:32'],
            'vat_number' => ['nullable', 'string', 'max:32'],
            'category_id' => ['required', 'exists:registration_categories,id'],
            'participants' => ['required', 'array', 'min:1'],
            'participants.*.first_name' => ['required', 'string', 'max:120'],
            'participants.*.last_name' => ['required', 'string', 'max:120'],
            'participants.*.email' => ['required', 'email'],
            'participants.*.phone' => ['nullable', 'string'],
        ]);

        $category = RegistrationCategory::find($validated['category_id']);

        $group = DB::transaction(function () use ($validated, $category) {
            $group = GroupRegistration::create([
                'reference' => 'GRP-'.now()->format('Y').'-'.Str::upper(Str::random(6)),
                'organization_name' => $validated['organization_name'],
                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'] ?? null,
                'vat_number' => $validated['vat_number'] ?? null,
                'expected_count' => count($validated['participants']),
                'status' => 'pending',
                'currency' => $category->currency,
                'total_amount' => $category->currentPrice() * count($validated['participants']),
            ]);

            foreach ($validated['participants'] as $p) {
                $participant = Participant::create([
                    'first_name' => $p['first_name'],
                    'last_name' => $p['last_name'],
                    'email' => $p['email'],
                    'phone' => $p['phone'] ?? null,
                    'organization' => $validated['organization_name'],
                ]);

                $reference = sprintf('CONG-%s-%05d', now()->format('Y'), Registration::count() + 1);

                Registration::create([
                    'reference' => $reference,
                    'participant_id' => $participant->id,
                    'category_id' => $category->id,
                    'group_registration_id' => $group->id,
                    'amount_due' => $category->currentPrice(),
                    'currency' => $category->currency,
                    'pricing_tier' => $category->currentTier(),
                    'status' => 'awaiting_payment',
                    'source' => 'imported',
                    'qr_token' => Str::random(48),
                    'submitted_at' => now(),
                ]);

                $group->increment('confirmed_count');
            }

            return $group;
        });

        return redirect()->route('admin.groups.index')->with('success', "Groupe {$group->reference} créé avec {$group->confirmed_count} participants.");
    }
}

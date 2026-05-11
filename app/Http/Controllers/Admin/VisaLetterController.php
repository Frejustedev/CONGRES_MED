<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Services\Pdf\VisaLetterPdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VisaLetterController extends Controller
{
    public function index(): Response
    {
        $requests = Registration::with('participant', 'category')
            ->where('visa_letter_requested', true)
            ->orderByRaw('visa_letter_issued asc')
            ->latest()
            ->paginate(25)
            ->through(fn ($r) => [
                'id' => $r->id,
                'reference' => $r->reference,
                'participant' => $r->participant->fullName(),
                'email' => $r->participant->email,
                'organization' => $r->participant->organization,
                'country' => $r->participant->country,
                'category' => $r->category->name,
                'status' => $r->status,
                'issued' => $r->visa_letter_issued,
                'has_pdf' => (bool) $r->visa_letter_path,
            ]);

        return Inertia::render('Admin/VisaLetters/Index', [
            'requests' => $requests,
        ]);
    }

    public function generate(int $registrationId, VisaLetterPdfService $service): RedirectResponse
    {
        $registration = Registration::with('participant')->findOrFail($registrationId);
        $service->generate($registration);

        return back()->with('success', 'Lettre d\'invitation générée.');
    }
}

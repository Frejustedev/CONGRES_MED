<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailTemplateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/EmailTemplates/Index', [
            'templates' => EmailTemplate::orderBy('key')->get(),
            'availableKeys' => [
                'registration.confirmed' => 'Confirmation d\'inscription',
                'payment.received' => 'Paiement reçu',
                'abstract.submitted' => 'Résumé soumis',
                'abstract.accepted' => 'Résumé accepté',
                'abstract.rejected' => 'Résumé refusé',
                'abstract.revision_required' => 'Résumé : révision demandée',
                'reviewer.assigned' => 'Nouvelle évaluation assignée',
                'visa.letter_ready' => 'Lettre d\'invitation prête',
                'event.reminder' => 'Rappel J-7 du congrès',
                'survey.invitation' => 'Invitation au sondage post-événement',
            ],
        ]);
    }

    public function edit(int $id): Response
    {
        $template = EmailTemplate::findOrFail($id);
        return Inertia::render('Admin/EmailTemplates/Edit', [
            'template' => $template,
            'availableVariables' => $this->getVariablesFor($template->key),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        EmailTemplate::create($data);
        return redirect()->route('admin.email-templates.index')->with('success', 'Template créé.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $template = EmailTemplate::findOrFail($id);
        $data = $this->validateData($request);
        $template->update($data);
        return back()->with('success', 'Template mis à jour.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'key' => ['required', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'locale' => ['required', 'in:fr,en'],
            'subject' => ['required', 'string', 'max:300'],
            'body_html' => ['required', 'string'],
            'body_text' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);
    }

    protected function getVariablesFor(string $key): array
    {
        $common = ['{{event_name}}', '{{event_theme}}', '{{event_start_date}}', '{{event_end_date}}', '{{event_venue}}', '{{support_email}}'];

        return match (true) {
            str_starts_with($key, 'registration.') => array_merge($common, ['{{participant_name}}', '{{participant_email}}', '{{reference}}', '{{amount_due}}', '{{currency}}', '{{payment_url}}']),
            str_starts_with($key, 'payment.') => array_merge($common, ['{{participant_name}}', '{{reference}}', '{{amount_paid}}', '{{badge_url}}', '{{invoice_url}}']),
            str_starts_with($key, 'abstract.') => array_merge($common, ['{{author_name}}', '{{abstract_title}}', '{{abstract_reference}}', '{{decision_comments}}']),
            str_starts_with($key, 'reviewer.') => array_merge($common, ['{{reviewer_name}}', '{{abstract_title}}', '{{deadline}}', '{{review_url}}']),
            str_starts_with($key, 'visa.') => array_merge($common, ['{{participant_name}}', '{{reference}}', '{{download_url}}']),
            str_starts_with($key, 'survey.') => array_merge($common, ['{{participant_name}}', '{{survey_url}}']),
            default => $common,
        };
    }
}

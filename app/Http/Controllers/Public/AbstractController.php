<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\SubmitAbstractRequest;
use App\Models\Abstrakt;
use App\Models\ThematicArea;
use App\Services\Abstracts\SubmissionService;
use App\Settings\EventSettings;
use App\Settings\ModulesSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AbstractController extends Controller
{
    public function __construct(protected SubmissionService $submission)
    {
    }

    public function submitForm(): Response|RedirectResponse
    {
        $modules = app(ModulesSettings::class);
        if (! $modules->abstracts_enabled) {
            return redirect()->route('home')->with('warning', 'La soumission de résumés est désactivée.');
        }

        $settings = app(EventSettings::class);
        $now = now();

        if ($settings->abstracts_close_at && $now->gte($settings->abstracts_close_at)) {
            return Inertia::render('Public/Abstracts/Closed', [
                'closedAt' => $settings->abstracts_close_at->format('c'),
            ]);
        }

        return Inertia::render('Public/Abstracts/Submit', [
            'thematicAreas' => ThematicArea::where('is_active', true)->orderBy('display_order')->get(['id', 'slug', 'name', 'color']),
            'deadline' => $settings->abstracts_close_at?->format('c'),
            'countries' => $this->countries(),
        ]);
    }

    public function submit(SubmitAbstractRequest $request): RedirectResponse
    {
        $userId = $request->user()?->id;
        $abstract = $this->submission->create($request->validated(), $userId);

        return redirect()
            ->route('abstracts.submitted', $abstract->reference)
            ->with('success', 'Votre résumé a bien été soumis.');
    }

    public function submitted(string $reference): Response
    {
        $abstract = Abstrakt::with(['thematicArea', 'authors'])
            ->where('reference', $reference)
            ->firstOrFail();

        return Inertia::render('Public/Abstracts/Submitted', [
            'abstract' => [
                'reference' => $abstract->reference,
                'title' => $abstract->title,
                'submission_type' => $abstract->submission_type,
                'thematic_area' => $abstract->thematicArea?->name,
                'status' => $abstract->status,
                'word_count' => $abstract->word_count,
                'submitted_at' => $abstract->submitted_at?->toIso8601String(),
                'authors_count' => $abstract->authors->count(),
                'corresponding_author_email' => $abstract->correspondingAuthor()?->email,
            ],
        ]);
    }

    public function lookup(): Response
    {
        return Inertia::render('Public/Abstracts/Lookup');
    }

    public function lookupSubmit(Request $request): Response|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'reference' => ['required', 'string'],
        ]);

        $abstract = Abstrakt::with(['authors', 'thematicArea', 'reviews'])
            ->where('reference', $validated['reference'])
            ->whereHas('authors', fn ($q) => $q->where('email', $validated['email'])->orWhere(fn ($qq) => $qq->where('is_corresponding', true)->where('email', $validated['email'])))
            ->first();

        if (! $abstract) {
            return back()->withErrors(['reference' => 'Référence ou e-mail introuvable.'])->withInput();
        }

        return Inertia::render('Public/Abstracts/Detail', [
            'abstract' => [
                'reference' => $abstract->reference,
                'title' => $abstract->title,
                'submission_type' => $abstract->submission_type,
                'thematic_area' => $abstract->thematicArea?->name,
                'status' => $abstract->status,
                'language' => $abstract->language,
                'keywords' => $abstract->keywords,
                'word_count' => $abstract->word_count,
                'submitted_at' => $abstract->submitted_at?->toIso8601String(),
                'decision_at' => $abstract->decision_at?->toIso8601String(),
                'decision_comments' => $abstract->decision_comments,
                'introduction' => $abstract->introduction,
                'methods' => $abstract->methods,
                'results' => $abstract->results,
                'discussion' => $abstract->discussion,
                'conclusion' => $abstract->conclusion,
                'case_description' => $abstract->case_description,
                'authors' => $abstract->authors->map(fn ($a) => [
                    'name' => trim($a->salutation.' '.$a->first_name.' '.$a->last_name),
                    'email' => $a->email,
                    'affiliation' => $a->affiliation,
                    'is_corresponding' => $a->is_corresponding,
                    'is_presenter' => $a->is_presenter,
                ]),
            ],
        ]);
    }

    protected function countries(): array
    {
        return [
            ['code' => 'BJ', 'name' => 'Bénin'],
            ['code' => 'BF', 'name' => 'Burkina Faso'],
            ['code' => 'CI', 'name' => "Côte d'Ivoire"],
            ['code' => 'GH', 'name' => 'Ghana'],
            ['code' => 'ML', 'name' => 'Mali'],
            ['code' => 'NE', 'name' => 'Niger'],
            ['code' => 'NG', 'name' => 'Nigéria'],
            ['code' => 'SN', 'name' => 'Sénégal'],
            ['code' => 'TG', 'name' => 'Togo'],
            ['code' => 'CM', 'name' => 'Cameroun'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'BE', 'name' => 'Belgique'],
            ['code' => 'CH', 'name' => 'Suisse'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'US', 'name' => 'États-Unis'],
        ];
    }
}

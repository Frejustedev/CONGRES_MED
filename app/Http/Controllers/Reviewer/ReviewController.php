<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\AbstractReview;
use App\Models\Abstrakt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function dashboard(Request $request): Response
    {
        $user = $request->user();

        $reviews = AbstractReview::with(['abstrakt.thematicArea', 'abstrakt.authors'])
            ->where('reviewer_user_id', $user->id)
            ->orderBy('due_at')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'abstract_reference' => $r->abstrakt->reference,
                'abstract_title' => $r->abstrakt->title,
                'thematic_area' => $r->abstrakt->thematicArea?->name,
                'submission_type' => $r->abstrakt->submission_type,
                'status' => $r->status,
                'assigned_at' => $r->assigned_at?->toIso8601String(),
                'due_at' => $r->due_at?->toIso8601String(),
                'submitted_at' => $r->submitted_at?->toIso8601String(),
                'recommendation' => $r->recommendation,
            ]);

        return Inertia::render('Reviewer/Dashboard', [
            'reviews' => $reviews,
            'stats' => [
                'assigned' => $reviews->where('status', 'assigned')->count(),
                'in_progress' => $reviews->where('status', 'in_progress')->count(),
                'submitted' => $reviews->where('status', 'submitted')->count(),
            ],
        ]);
    }

    public function show(Request $request, int $reviewId): Response
    {
        $review = AbstractReview::with(['abstrakt.thematicArea', 'abstrakt.authors', 'abstrakt.files'])
            ->where('id', $reviewId)
            ->where('reviewer_user_id', $request->user()->id)
            ->firstOrFail();

        $abstract = $review->abstrakt;

        // Anonymisation double-blind : on cache identité auteurs
        $authorsCount = $abstract->authors->count();

        return Inertia::render('Reviewer/Review', [
            'review' => [
                'id' => $review->id,
                'status' => $review->status,
                'assigned_at' => $review->assigned_at?->toIso8601String(),
                'due_at' => $review->due_at?->toIso8601String(),
                'submitted_at' => $review->submitted_at?->toIso8601String(),
                'score_originality' => $review->score_originality,
                'score_methodology' => $review->score_methodology,
                'score_relevance' => $review->score_relevance,
                'score_clarity' => $review->score_clarity,
                'score_overall' => $review->score_overall,
                'recommendation' => $review->recommendation,
                'comments_to_authors' => $review->comments_to_authors,
                'comments_to_editors' => $review->comments_to_editors,
                'conflict_declared' => $review->conflict_declared,
                'conflict_description' => $review->conflict_description,
            ],
            'abstract' => [
                'reference' => $abstract->reference,
                'title' => $abstract->title,
                'submission_type' => $abstract->submission_type,
                'thematic_area' => $abstract->thematicArea?->name,
                'language' => $abstract->language,
                'keywords' => $abstract->keywords,
                'word_count' => $abstract->word_count,
                'introduction' => $abstract->introduction,
                'methods' => $abstract->methods,
                'results' => $abstract->results,
                'discussion' => $abstract->discussion,
                'conclusion' => $abstract->conclusion,
                'case_description' => $abstract->case_description,
                'has_conflict_of_interest' => $abstract->has_conflict_of_interest,
                'conflict_disclosure' => $abstract->conflict_disclosure,
                'funding_disclosed' => $abstract->funding_disclosed,
                'ethical_approval' => $abstract->ethical_approval,
                'anonymized_authors_count' => $authorsCount,
            ],
        ]);
    }

    public function submit(Request $request, int $reviewId): RedirectResponse
    {
        $review = AbstractReview::where('id', $reviewId)
            ->where('reviewer_user_id', $request->user()->id)
            ->firstOrFail();

        $validated = $request->validate([
            'score_originality' => ['required', 'integer', 'min:1', 'max:10'],
            'score_methodology' => ['required', 'integer', 'min:1', 'max:10'],
            'score_relevance' => ['required', 'integer', 'min:1', 'max:10'],
            'score_clarity' => ['required', 'integer', 'min:1', 'max:10'],
            'score_overall' => ['required', 'integer', 'min:1', 'max:10'],
            'recommendation' => ['required', 'in:accept,accept_minor,accept_major,reject,undecided'],
            'comments_to_authors' => ['required', 'string', 'min:30', 'max:5000'],
            'comments_to_editors' => ['nullable', 'string', 'max:3000'],
            'conflict_declared' => ['boolean'],
            'conflict_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $weighted = ($validated['score_originality'] * 0.25)
            + ($validated['score_methodology'] * 0.30)
            + ($validated['score_relevance'] * 0.20)
            + ($validated['score_clarity'] * 0.10)
            + ($validated['score_overall'] * 0.15);

        $review->update([
            ...$validated,
            'weighted_score' => round($weighted, 2),
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Recalcule la moyenne sur l'abstract
        $abstract = $review->abstrakt;
        $submittedReviews = $abstract->reviews()->where('status', 'submitted')->get();
        if ($submittedReviews->count() > 0) {
            $abstract->update([
                'reviewer_count' => $submittedReviews->count(),
                'average_score' => round($submittedReviews->avg('weighted_score'), 2),
            ]);
        }

        return redirect()->route('reviewer.dashboard')->with('success', 'Évaluation enregistrée.');
    }
}

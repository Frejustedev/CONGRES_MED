<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractReview;
use App\Models\Abstrakt;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AbstractManagementController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Abstrakt::with(['authors', 'thematicArea', 'reviews']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $abstracts = $query->latest('submitted_at')
            ->paginate(25)
            ->through(fn ($a) => [
                'id' => $a->id,
                'reference' => $a->reference,
                'title' => $a->title,
                'submission_type' => $a->submission_type,
                'thematic_area' => $a->thematicArea?->name,
                'status' => $a->status,
                'authors_count' => $a->authors->count(),
                'reviewer_count' => $a->reviewer_count,
                'average_score' => $a->average_score ? (float) $a->average_score : null,
                'submitted_at' => $a->submitted_at?->toIso8601String(),
            ]);

        return Inertia::render('Admin/Abstracts/Index', [
            'abstracts' => $abstracts,
            'filters' => $request->only(['status']),
            'statuses' => ['draft', 'submitted', 'under_review', 'revision_required', 'accepted', 'rejected', 'withdrawn'],
        ]);
    }

    public function show(int $id): Response
    {
        $abstract = Abstrakt::with(['authors', 'thematicArea', 'reviews.reviewer'])->findOrFail($id);

        $reviewers = User::role('reviewer')->get(['id', 'name', 'email'])->map(fn ($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'already_assigned' => $abstract->reviews->pluck('reviewer_user_id')->contains($u->id),
        ]);

        return Inertia::render('Admin/Abstracts/Show', [
            'abstract' => [
                'id' => $abstract->id,
                'reference' => $abstract->reference,
                'title' => $abstract->title,
                'submission_type' => $abstract->submission_type,
                'thematic_area' => $abstract->thematicArea?->name,
                'status' => $abstract->status,
                'keywords' => $abstract->keywords,
                'word_count' => $abstract->word_count,
                'has_conflict' => $abstract->has_conflict_of_interest,
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
                ]),
                'reviews' => $abstract->reviews->map(fn ($r) => [
                    'id' => $r->id,
                    'reviewer_name' => $r->reviewer->name,
                    'status' => $r->status,
                    'weighted_score' => $r->weighted_score ? (float) $r->weighted_score : null,
                    'recommendation' => $r->recommendation,
                    'submitted_at' => $r->submitted_at?->toIso8601String(),
                ]),
                'average_score' => $abstract->average_score ? (float) $abstract->average_score : null,
                'decision_at' => $abstract->decision_at?->toIso8601String(),
                'decision_comments' => $abstract->decision_comments,
            ],
            'reviewers' => $reviewers,
        ]);
    }

    public function assignReviewer(Request $request, int $abstractId): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_user_id' => ['required', 'exists:users,id'],
            'due_at' => ['nullable', 'date', 'after:today'],
        ]);

        $abstract = Abstrakt::findOrFail($abstractId);

        AbstractReview::firstOrCreate(
            ['abstract_id' => $abstract->id, 'reviewer_user_id' => $validated['reviewer_user_id']],
            [
                'assigned_by_user_id' => $request->user()->id,
                'status' => 'assigned',
                'assigned_at' => now(),
                'due_at' => $validated['due_at'] ?? now()->addDays(14),
            ],
        );

        if ($abstract->status === 'submitted') {
            $abstract->update(['status' => 'under_review']);
        }

        return back()->with('success', 'Reviewer assigné.');
    }

    public function decide(Request $request, int $abstractId): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected,revision_required'],
            'decision_comments' => ['nullable', 'string', 'max:3000'],
        ]);

        $abstract = Abstrakt::findOrFail($abstractId);
        $abstract->update([
            'status' => $validated['status'],
            'decision_at' => now(),
            'decision_comments' => $validated['decision_comments'] ?? null,
            'decided_by_user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Décision enregistrée.');
    }
}

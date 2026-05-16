<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SatisfactionSurvey;
use Inertia\Inertia;
use Inertia\Response;

class SurveyDashboardController extends Controller
{
    public function __invoke(): Response
    {
        $surveys = SatisfactionSurvey::all();
        $count = $surveys->count();

        $nps = $surveys->whereNotNull('nps_score');
        $promoters = $nps->where('nps_score', '>=', 9)->count();
        $detractors = $nps->where('nps_score', '<=', 6)->count();
        $npsScore = $nps->count() > 0 ? (int) round((($promoters - $detractors) / $nps->count()) * 100) : null;

        $averages = [
            'overall' => round($surveys->avg('overall_rating') ?? 0, 2),
            'content' => round($surveys->avg('content_rating') ?? 0, 2),
            'venue' => round($surveys->avg('venue_rating') ?? 0, 2),
            'organization' => round($surveys->avg('organization_rating') ?? 0, 2),
            'networking' => round($surveys->avg('networking_rating') ?? 0, 2),
        ];

        $recommend = $surveys->where('would_recommend', true)->count();
        $return = $surveys->where('would_return', true)->count();

        $allTopics = $surveys->pluck('topics_of_interest_next_edition')->filter()->flatten()->countBy()->sortDesc()->take(10);

        return Inertia::render('Admin/SurveyDashboard', [
            'stats' => [
                'total' => $count,
                'nps' => $npsScore,
                'promoters' => $promoters,
                'detractors' => $detractors,
                'averages' => $averages,
                'recommend_pct' => $count > 0 ? round(($recommend / $count) * 100, 1) : 0,
                'return_pct' => $count > 0 ? round(($return / $count) * 100, 1) : 0,
            ],
            'topTopics' => $allTopics,
            'recentComments' => $surveys->whereNotNull('comments')
                ->sortByDesc('submitted_at')
                ->take(20)
                ->values()
                ->map(fn ($s) => [
                    'overall_rating' => $s->overall_rating,
                    'nps_score' => $s->nps_score,
                    'positive_feedback' => $s->positive_feedback,
                    'improvement_feedback' => $s->improvement_feedback,
                    'comments' => $s->comments,
                    'submitted_at' => $s->submitted_at?->toIso8601String(),
                ]),
        ]);
    }
}

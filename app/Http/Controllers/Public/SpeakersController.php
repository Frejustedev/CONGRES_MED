<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Inertia\Inertia;
use Inertia\Response;

class SpeakersController extends Controller
{
    public function __invoke(): Response
    {
        $speakers = Speaker::query()
            ->where('is_published', true)
            ->orderByDesc('is_keynote')
            ->orderByDesc('is_featured')
            ->orderBy('display_order')
            ->orderBy('last_name')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'slug' => $s->slug,
                'name' => trim($s->salutation.' '.$s->first_name.' '.$s->last_name),
                'job_title' => $s->job_title,
                'affiliation' => $s->affiliation,
                'country' => $s->country,
                'photo_path' => $s->photo_path,
                'biography' => $s->biography,
                'is_keynote' => $s->is_keynote,
                'orcid' => $s->orcid,
                'linkedin' => $s->linkedin,
                'twitter' => $s->twitter,
                'website' => $s->website,
            ]);

        return Inertia::render('Public/Speakers', [
            'speakers' => $speakers,
            'keynoteCount' => $speakers->where('is_keynote', true)->count(),
            'totalCount' => $speakers->count(),
        ]);
    }
}

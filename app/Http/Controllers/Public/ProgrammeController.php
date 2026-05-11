<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProgramSession;
use App\Models\Room;
use App\Models\ThematicArea;
use Inertia\Inertia;
use Inertia\Response;

class ProgrammeController extends Controller
{
    public function __invoke(): Response
    {
        $sessions = ProgramSession::query()
            ->where('is_published', true)
            ->with(['room:id,slug,name,color', 'speakers:id,slug,first_name,last_name,salutation,job_title,affiliation,photo_path'])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn ($s) => $s->starts_at->format('Y-m-d'))
            ->map(fn ($daySessions, $day) => [
                'date' => $day,
                'label' => $daySessions->first()->starts_at->locale('fr')->isoFormat('dddd D MMMM YYYY'),
                'sessions' => $daySessions->map(fn ($s) => [
                    'id' => $s->id,
                    'slug' => $s->slug,
                    'type' => $s->type,
                    'title' => $s->title,
                    'subtitle' => $s->subtitle,
                    'starts_at' => $s->starts_at->format('H:i'),
                    'ends_at' => $s->ends_at->format('H:i'),
                    'room' => $s->room ? ['name' => $s->room->name, 'color' => $s->room->color] : null,
                    'language' => $s->language,
                    'is_featured' => $s->is_featured,
                    'cme_credits' => $s->cme_credits,
                    'speakers' => $s->speakers->map(fn ($sp) => [
                        'name' => trim($sp->salutation.' '.$sp->first_name.' '.$sp->last_name),
                        'title' => $sp->job_title,
                        'affiliation' => $sp->affiliation,
                    ]),
                ])->values(),
            ])
            ->values();

        return Inertia::render('Public/Programme', [
            'days' => $sessions,
            'rooms' => Room::where('is_active', true)->orderBy('display_order')->get(['id', 'slug', 'name', 'color']),
            'thematicAreas' => ThematicArea::where('is_active', true)->orderBy('display_order')->get(['id', 'slug', 'name', 'color']),
        ]);
    }
}

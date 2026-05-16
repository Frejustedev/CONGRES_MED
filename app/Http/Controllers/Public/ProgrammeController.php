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
    public function show(string $slug): Response
    {
        $session = ProgramSession::with(['room', 'speakers', 'parent', 'children.speakers'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return Inertia::render('Public/SessionDetail', [
            'session' => [
                'id' => $session->id,
                'slug' => $session->slug,
                'type' => $session->type,
                'title' => $session->title,
                'subtitle' => $session->subtitle,
                'description' => $session->description,
                'starts_at' => $session->starts_at->toIso8601String(),
                'ends_at' => $session->ends_at->toIso8601String(),
                'duration_minutes' => (int) $session->ends_at->diffInMinutes($session->starts_at),
                'language' => $session->language,
                'capacity' => $session->capacity,
                'cme_credits' => $session->cme_credits,
                'is_streamed' => $session->is_streamed,
                'stream_provider' => $session->stream_provider,
                'stream_url' => $session->stream_url,
                'stream_embed_code' => $session->stream_embed_code,
                'video_url' => $session->video_url,
                'slides_path' => $session->slides_path,
                'topics' => $session->topics,
                'room' => $session->room ? [
                    'name' => $session->room->name,
                    'color' => $session->room->color,
                    'capacity' => $session->room->capacity,
                ] : null,
                'speakers' => $session->speakers->map(fn ($s) => [
                    'name' => trim($s->salutation.' '.$s->first_name.' '.$s->last_name),
                    'title' => $s->job_title,
                    'affiliation' => $s->affiliation,
                    'photo_path' => $s->photo_path,
                    'role' => $s->pivot->role ?? 'speaker',
                    'talk_title' => $s->pivot->talk_title ?? null,
                ]),
                'children' => $session->children->map(fn ($c) => [
                    'slug' => $c->slug,
                    'title' => $c->title,
                    'starts_at' => $c->starts_at->format('H:i'),
                    'ends_at' => $c->ends_at->format('H:i'),
                    'speakers' => $c->speakers->map(fn ($s) => trim($s->first_name.' '.$s->last_name))->join(', '),
                ]),
                'parent' => $session->parent ? [
                    'slug' => $session->parent->slug,
                    'title' => $session->parent->title,
                ] : null,
            ],
        ]);
    }

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

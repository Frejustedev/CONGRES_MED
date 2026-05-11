<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RegistrationCategory;
use App\Models\Speaker;
use App\Models\Sponsor;
use App\Models\ThematicArea;
use App\Settings\EventSettings;
use App\Settings\ModulesSettings;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $event = Event::query()->where('is_active', true)->first();
        $eventSettings = app(EventSettings::class);
        $modules = app(ModulesSettings::class);

        return Inertia::render('Public/Home', [
            'event' => $event ? [
                'name' => $event->name,
                'tagline' => $event->tagline,
                'theme' => $event->theme,
                'description' => $event->description,
                'starts_at' => $event->starts_at?->toIso8601String(),
                'ends_at' => $event->ends_at?->toIso8601String(),
                'venue_name' => $event->venue_name,
                'venue_city' => $event->venue_city,
                'venue_country' => $event->venue_country,
                'status' => $event->status,
                'registration_open' => $event->isRegistrationOpen(),
                'abstracts_open_at' => $event->abstracts_open_at?->toIso8601String(),
                'abstracts_close_at' => $event->abstracts_close_at?->toIso8601String(),
            ] : null,
            'eventDates' => [
                'starts_at' => $eventSettings->start_date?->format('c'),
                'ends_at' => $eventSettings->end_date?->format('c'),
            ],
            'thematicAreas' => ThematicArea::where('is_active', true)
                ->orderBy('display_order')
                ->get(['id', 'slug', 'name', 'color']),
            'featuredSpeakers' => $modules->speakers_enabled
                ? Speaker::where('is_published', true)
                    ->where('is_featured', true)
                    ->orderBy('display_order')
                    ->limit(6)
                    ->get(['id', 'slug', 'first_name', 'last_name', 'salutation', 'job_title', 'affiliation', 'country', 'photo_path', 'is_keynote'])
                : [],
            'sponsors' => $modules->sponsors_enabled
                ? Sponsor::where('is_published', true)
                    ->orderByRaw("FIELD(tier, 'platinum', 'gold', 'silver', 'bronze', 'partner', 'institutional', 'media')")
                    ->orderBy('display_order')
                    ->get(['id', 'slug', 'name', 'tier', 'logo_path', 'website'])
                : [],
            'registrationCategories' => $modules->registrations_enabled
                ? RegistrationCategory::where('is_active', true)
                    ->where('is_public', true)
                    ->orderBy('display_order')
                    ->get()
                    ->map(fn ($c) => [
                        'id' => $c->id,
                        'slug' => $c->slug,
                        'name' => $c->name,
                        'description' => $c->description,
                        'current_price' => $c->currentPrice(),
                        'current_tier' => $c->currentTier(),
                        'currency' => $c->currency,
                    ])
                : [],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Settings\EventSettings;
use Inertia\Inertia;
use Inertia\Response;

class InfosController extends Controller
{
    public function __invoke(): Response
    {
        $event = Event::query()->where('is_active', true)->first();
        $settings = app(EventSettings::class);

        return Inertia::render('Public/PracticalInfo', [
            'venue' => $event ? [
                'name' => $event->venue_name,
                'address' => $event->venue_address,
                'city' => $event->venue_city,
                'country' => $event->venue_country,
                'latitude' => $event->venue_latitude,
                'longitude' => $event->venue_longitude,
            ] : null,
            'support' => [
                'email' => $settings->support_email,
                'phone' => $settings->support_phone,
                'whatsapp' => $settings->support_whatsapp,
            ],
            'dates' => $event ? [
                'starts_at' => $event->starts_at?->toIso8601String(),
                'ends_at' => $event->ends_at?->toIso8601String(),
            ] : null,
        ]);
    }
}

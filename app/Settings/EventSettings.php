<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EventSettings extends Settings
{
    public string $name;
    public string $tagline;
    public ?string $theme;
    public ?string $president_name;
    public ?string $president_title;
    public ?string $president_message;
    public ?\DateTime $start_date;
    public ?\DateTime $end_date;
    public string $timezone;
    public ?string $venue_name;
    public ?string $venue_address;
    public ?string $venue_city;
    public ?string $venue_country;
    public ?float $venue_latitude;
    public ?float $venue_longitude;
    public ?\DateTime $registration_open_at;
    public ?\DateTime $registration_close_at;
    public ?\DateTime $abstracts_open_at;
    public ?\DateTime $abstracts_close_at;
    public string $support_email;
    public ?string $support_phone;
    public ?string $support_whatsapp;
    public array $social_links;

    public static function group(): string
    {
        return 'event';
    }
}

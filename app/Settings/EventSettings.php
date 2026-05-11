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
    public ?\DateTimeInterface $start_date;
    public ?\DateTimeInterface $end_date;
    public string $timezone;
    public ?string $venue_name;
    public ?string $venue_address;
    public ?string $venue_city;
    public ?string $venue_country;
    public ?float $venue_latitude;
    public ?float $venue_longitude;
    public ?\DateTimeInterface $registration_open_at;
    public ?\DateTimeInterface $registration_close_at;
    public ?\DateTimeInterface $abstracts_open_at;
    public ?\DateTimeInterface $abstracts_close_at;
    public string $support_email;
    public ?string $support_phone;
    public ?string $support_whatsapp;
    public array $social_links;

    public static function group(): string
    {
        return 'event';
    }
}

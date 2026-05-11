<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ModulesSettings extends Settings
{
    public bool $public_portal_enabled;
    public bool $registrations_enabled;
    public bool $payments_enabled;
    public bool $abstracts_enabled;
    public bool $peer_review_enabled;
    public bool $sessions_enabled;
    public bool $speakers_enabled;
    public bool $sponsors_enabled;
    public bool $exhibitors_enabled;
    public bool $symposiums_enabled;
    public bool $streaming_enabled;
    public bool $cme_enabled;
    public bool $networking_enabled;
    public bool $eposters_enabled;
    public bool $live_qa_enabled;
    public bool $visa_letters_enabled;
    public bool $group_registration_enabled;
    public bool $multi_language_enabled;
    public bool $blog_enabled;
    public bool $faq_enabled;

    public static function group(): string
    {
        return 'modules';
    }
}

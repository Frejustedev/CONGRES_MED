<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('event.name', 'Mon Congrès');
        $this->migrator->add('event.tagline', '');
        $this->migrator->add('event.theme', null);
        $this->migrator->add('event.president_name', null);
        $this->migrator->add('event.president_title', null);
        $this->migrator->add('event.president_message', null);
        $this->migrator->add('event.start_date', null);
        $this->migrator->add('event.end_date', null);
        $this->migrator->add('event.timezone', 'Africa/Porto-Novo');
        $this->migrator->add('event.venue_name', null);
        $this->migrator->add('event.venue_address', null);
        $this->migrator->add('event.venue_city', null);
        $this->migrator->add('event.venue_country', null);
        $this->migrator->add('event.venue_latitude', null);
        $this->migrator->add('event.venue_longitude', null);
        $this->migrator->add('event.registration_open_at', null);
        $this->migrator->add('event.registration_close_at', null);
        $this->migrator->add('event.abstracts_open_at', null);
        $this->migrator->add('event.abstracts_close_at', null);
        $this->migrator->add('event.support_email', 'support@congresia.test');
        $this->migrator->add('event.support_phone', null);
        $this->migrator->add('event.support_whatsapp', null);
        $this->migrator->add('event.social_links', []);
    }
};

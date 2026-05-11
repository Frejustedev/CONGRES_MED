<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('modules.public_portal_enabled', true);
        $this->migrator->add('modules.registrations_enabled', true);
        $this->migrator->add('modules.payments_enabled', true);
        $this->migrator->add('modules.abstracts_enabled', true);
        $this->migrator->add('modules.peer_review_enabled', true);
        $this->migrator->add('modules.sessions_enabled', true);
        $this->migrator->add('modules.speakers_enabled', true);
        $this->migrator->add('modules.sponsors_enabled', true);
        $this->migrator->add('modules.exhibitors_enabled', true);
        $this->migrator->add('modules.symposiums_enabled', true);
        $this->migrator->add('modules.streaming_enabled', false);
        $this->migrator->add('modules.cme_enabled', true);
        $this->migrator->add('modules.networking_enabled', false);
        $this->migrator->add('modules.eposters_enabled', true);
        $this->migrator->add('modules.live_qa_enabled', false);
        $this->migrator->add('modules.visa_letters_enabled', true);
        $this->migrator->add('modules.group_registration_enabled', true);
        $this->migrator->add('modules.multi_language_enabled', true);
        $this->migrator->add('modules.blog_enabled', false);
        $this->migrator->add('modules.faq_enabled', true);
    }
};

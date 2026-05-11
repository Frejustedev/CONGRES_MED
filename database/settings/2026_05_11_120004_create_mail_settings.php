<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.from_address', null);
        $this->migrator->add('mail.from_name', null);
        $this->migrator->add('mail.reply_to_address', null);
        $this->migrator->add('mail.signature_html', null);
        $this->migrator->add('mail.smtp_host', null);
        $this->migrator->add('mail.smtp_port', null);
        $this->migrator->add('mail.smtp_username', null);
        $this->migrator->add('mail.smtp_password', null);
        $this->migrator->add('mail.smtp_encryption', null);
        $this->migrator->add('mail.use_app_smtp', true);
    }
};

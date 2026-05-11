<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('branding.logo_path', null);
        $this->migrator->add('branding.logo_dark_path', null);
        $this->migrator->add('branding.favicon_path', null);
        $this->migrator->add('branding.hero_image_path', null);
        $this->migrator->add('branding.og_image_path', null);
        $this->migrator->add('branding.color_primary', '#0ea5e9');
        $this->migrator->add('branding.color_primary_foreground', '#ffffff');
        $this->migrator->add('branding.color_secondary', '#64748b');
        $this->migrator->add('branding.color_secondary_foreground', '#ffffff');
        $this->migrator->add('branding.color_accent', '#f59e0b');
        $this->migrator->add('branding.color_accent_foreground', '#0f172a');
        $this->migrator->add('branding.color_background', '#ffffff');
        $this->migrator->add('branding.color_foreground', '#0f172a');
        $this->migrator->add('branding.color_muted', '#f1f5f9');
        $this->migrator->add('branding.color_muted_foreground', '#64748b');
        $this->migrator->add('branding.color_destructive', '#ef4444');
        $this->migrator->add('branding.font_heading', 'Inter');
        $this->migrator->add('branding.font_body', 'Inter');
        $this->migrator->add('branding.dark_mode_enabled', true);
        $this->migrator->add('branding.default_theme', 'system');
    }
};

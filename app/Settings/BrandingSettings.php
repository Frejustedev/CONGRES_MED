<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BrandingSettings extends Settings
{
    public ?string $logo_path;
    public ?string $logo_dark_path;
    public ?string $favicon_path;
    public ?string $hero_image_path;
    public ?string $og_image_path;
    public string $color_primary;
    public string $color_primary_foreground;
    public string $color_secondary;
    public string $color_secondary_foreground;
    public string $color_accent;
    public string $color_accent_foreground;
    public string $color_background;
    public string $color_foreground;
    public string $color_muted;
    public string $color_muted_foreground;
    public string $color_destructive;
    public string $font_heading;
    public string $font_body;
    public bool $dark_mode_enabled;
    public string $default_theme;

    public static function group(): string
    {
        return 'branding';
    }
}

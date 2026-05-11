<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MailSettings extends Settings
{
    public ?string $from_address;
    public ?string $from_name;
    public ?string $reply_to_address;
    public ?string $signature_html;
    public ?string $smtp_host;
    public ?int $smtp_port;
    public ?string $smtp_username;
    public ?string $smtp_password;
    public ?string $smtp_encryption;
    public bool $use_app_smtp;

    public static function group(): string
    {
        return 'mail';
    }
}

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PaymentSettings extends Settings
{
    public string $default_currency;
    public array $accepted_currencies;
    public bool $kkiapay_enabled;
    public bool $stripe_enabled;
    public bool $bank_transfer_enabled;
    public bool $cash_on_site_enabled;
    public string $invoice_prefix;
    public int $invoice_next_number;
    public ?string $invoice_legal_mentions;
    public ?string $invoice_vat_number;
    public ?float $vat_rate;
    public ?string $bank_account_holder;
    public ?string $bank_name;
    public ?string $bank_iban;
    public ?string $bank_bic;
    public ?string $refund_policy;

    public static function group(): string
    {
        return 'payment';
    }
}

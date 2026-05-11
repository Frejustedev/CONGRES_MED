<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('payment.default_currency', 'XOF');
        $this->migrator->add('payment.accepted_currencies', ['XOF', 'EUR', 'USD']);
        $this->migrator->add('payment.kkiapay_enabled', true);
        $this->migrator->add('payment.stripe_enabled', true);
        $this->migrator->add('payment.bank_transfer_enabled', false);
        $this->migrator->add('payment.cash_on_site_enabled', true);
        $this->migrator->add('payment.invoice_prefix', 'CONG');
        $this->migrator->add('payment.invoice_next_number', 1);
        $this->migrator->add('payment.invoice_legal_mentions', null);
        $this->migrator->add('payment.invoice_vat_number', null);
        $this->migrator->add('payment.vat_rate', null);
        $this->migrator->add('payment.bank_account_holder', null);
        $this->migrator->add('payment.bank_name', null);
        $this->migrator->add('payment.bank_iban', null);
        $this->migrator->add('payment.bank_bic', null);
        $this->migrator->add('payment.refund_policy', null);
    }
};

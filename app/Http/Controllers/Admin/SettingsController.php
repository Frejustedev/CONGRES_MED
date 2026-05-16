<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\BrandingSettings;
use App\Settings\EventSettings;
use App\Settings\MailSettings;
use App\Settings\ModulesSettings;
use App\Settings\PaymentSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function event(): Response
    {
        return Inertia::render('Admin/Settings/Event', [
            'settings' => $this->serializeSettings(app(EventSettings::class)),
        ]);
    }

    public function updateEvent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'theme' => ['nullable', 'string', 'max:200'],
            'president_name' => ['nullable', 'string', 'max:120'],
            'president_title' => ['nullable', 'string', 'max:200'],
            'president_message' => ['nullable', 'string', 'max:5000'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'timezone' => ['required', 'string', 'max:64'],
            'venue_name' => ['nullable', 'string', 'max:200'],
            'venue_address' => ['nullable', 'string', 'max:300'],
            'venue_city' => ['nullable', 'string', 'max:120'],
            'venue_country' => ['nullable', 'string', 'size:2'],
            'venue_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'venue_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'registration_open_at' => ['nullable', 'date'],
            'registration_close_at' => ['nullable', 'date'],
            'abstracts_open_at' => ['nullable', 'date'],
            'abstracts_close_at' => ['nullable', 'date'],
            'support_email' => ['required', 'email'],
            'support_phone' => ['nullable', 'string', 'max:32'],
            'support_whatsapp' => ['nullable', 'string', 'max:32'],
            'social_links' => ['nullable', 'array'],
        ]);

        $settings = app(EventSettings::class);
        foreach ($validated as $key => $value) {
            if (str_ends_with($key, '_date') || str_ends_with($key, '_at')) {
                $settings->{$key} = $value ? new \DateTime($value) : null;
            } else {
                $settings->{$key} = $value;
            }
        }
        $settings->save();

        return back()->with('success', 'Paramètres événement mis à jour.');
    }

    public function branding(): Response
    {
        return Inertia::render('Admin/Settings/Branding', [
            'settings' => $this->serializeSettings(app(BrandingSettings::class)),
        ]);
    }

    public function updateBranding(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo_path' => ['nullable', 'string'],
            'logo_dark_path' => ['nullable', 'string'],
            'favicon_path' => ['nullable', 'string'],
            'hero_image_path' => ['nullable', 'string'],
            'color_primary' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_primary_foreground' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_secondary' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_secondary_foreground' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_accent' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_accent_foreground' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_background' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_foreground' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_muted' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_muted_foreground' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_destructive' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'font_heading' => ['required', 'string', 'max:120'],
            'font_body' => ['required', 'string', 'max:120'],
            'dark_mode_enabled' => ['boolean'],
            'default_theme' => ['required', 'in:light,dark,system'],
        ]);

        $settings = app(BrandingSettings::class);
        foreach ($validated as $key => $value) {
            $settings->{$key} = $value;
        }
        $settings->save();

        return back()->with('success', 'Branding mis à jour.');
    }

    public function modules(): Response
    {
        return Inertia::render('Admin/Settings/Modules', [
            'settings' => $this->serializeSettings(app(ModulesSettings::class)),
        ]);
    }

    public function updateModules(Request $request): RedirectResponse
    {
        $settings = app(ModulesSettings::class);
        $rules = [];
        foreach ((array) $settings->toArray() as $key => $_) {
            $rules[$key] = ['boolean'];
        }
        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            $settings->{$key} = (bool) $value;
        }
        $settings->save();

        return back()->with('success', 'Modules mis à jour.');
    }

    public function payment(): Response
    {
        return Inertia::render('Admin/Settings/Payment', [
            'settings' => $this->serializeSettings(app(PaymentSettings::class)),
        ]);
    }

    public function updatePayment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_currency' => ['required', 'string', 'size:3'],
            'accepted_currencies' => ['required', 'array', 'min:1'],
            'kkiapay_enabled' => ['boolean'],
            'stripe_enabled' => ['boolean'],
            'bank_transfer_enabled' => ['boolean'],
            'cash_on_site_enabled' => ['boolean'],
            'invoice_prefix' => ['required', 'string', 'max:16'],
            'invoice_next_number' => ['required', 'integer', 'min:1'],
            'invoice_legal_mentions' => ['nullable', 'string', 'max:2000'],
            'invoice_vat_number' => ['nullable', 'string', 'max:32'],
            'vat_rate' => ['nullable', 'numeric', 'between:0,100'],
            'bank_account_holder' => ['nullable', 'string', 'max:200'],
            'bank_name' => ['nullable', 'string', 'max:200'],
            'bank_iban' => ['nullable', 'string', 'max:64'],
            'bank_bic' => ['nullable', 'string', 'max:32'],
            'refund_policy' => ['nullable', 'string', 'max:5000'],
        ]);

        $settings = app(PaymentSettings::class);
        foreach ($validated as $key => $value) {
            $settings->{$key} = $value;
        }
        $settings->save();

        return back()->with('success', 'Paramètres paiement mis à jour.');
    }

    public function mail(): Response
    {
        return Inertia::render('Admin/Settings/Mail', [
            'settings' => $this->serializeSettings(app(MailSettings::class)),
        ]);
    }

    public function updateMail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'from_address' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:120'],
            'reply_to_address' => ['nullable', 'email'],
            'signature_html' => ['nullable', 'string', 'max:5000'],
            'smtp_host' => ['nullable', 'string', 'max:200'],
            'smtp_port' => ['nullable', 'integer', 'between:1,65535'],
            'smtp_username' => ['nullable', 'string', 'max:200'],
            'smtp_password' => ['nullable', 'string', 'max:200'],
            'smtp_encryption' => ['nullable', 'in:tls,ssl,none'],
            'use_app_smtp' => ['boolean'],
        ]);

        $settings = app(MailSettings::class);
        foreach ($validated as $key => $value) {
            $settings->{$key} = $value;
        }
        $settings->save();

        return back()->with('success', 'Paramètres mail mis à jour.');
    }

    protected function serializeSettings($settings): array
    {
        $data = $settings->toArray();
        foreach ($data as $k => $v) {
            if ($v instanceof \DateTimeInterface) {
                $data[$k] = $v->format('Y-m-d\TH:i');
            }
        }
        return $data;
    }
}

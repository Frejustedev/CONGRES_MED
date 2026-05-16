<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Settings\EventSettings;
use App\Settings\PaymentSettings;
use Inertia\Inertia;
use Inertia\Response;

class LegalController extends Controller
{
    public function terms(): Response
    {
        return Inertia::render('Public/Legal/Terms', $this->context());
    }

    public function privacy(): Response
    {
        return Inertia::render('Public/Legal/Privacy', $this->context());
    }

    public function mentions(): Response
    {
        return Inertia::render('Public/Legal/Mentions', $this->context());
    }

    protected function context(): array
    {
        $event = app(EventSettings::class);
        $payment = app(PaymentSettings::class);

        return [
            'event' => [
                'name' => $event->name,
                'support_email' => $event->support_email,
                'support_phone' => $event->support_phone,
                'venue_city' => $event->venue_city,
                'venue_country' => $event->venue_country,
            ],
            'payment' => [
                'invoice_vat_number' => $payment->invoice_vat_number,
                'refund_policy' => $payment->refund_policy,
            ],
        ];
    }
}

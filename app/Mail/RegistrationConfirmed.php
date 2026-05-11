<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Registration $registration)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre inscription — '.config('app.name'),
            to: [$this->registration->participant->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmed',
            with: [
                'registration' => $this->registration,
                'participant' => $this->registration->participant,
                'category' => $this->registration->category,
                'paymentUrl' => route('payment.method', $this->registration->reference),
                'remaining' => $this->registration->remainingAmount(),
            ],
        );
    }
}

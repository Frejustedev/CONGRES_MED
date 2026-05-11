<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Registration $registration,
        public ?string $invoicePath = null,
        public ?string $badgePath = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Paiement confirmé — votre badge est prêt',
            to: [$this->registration->participant->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-received',
            with: [
                'registration' => $this->registration,
                'participant' => $this->registration->participant,
                'category' => $this->registration->category,
                'downloadBadgeUrl' => route('participant.download', [
                    'reference' => $this->registration->reference,
                    'type' => 'badge',
                ]),
                'downloadInvoiceUrl' => route('participant.download', [
                    'reference' => $this->registration->reference,
                    'type' => 'invoice',
                ]),
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        if ($this->badgePath && file_exists(storage_path('app/public/'.$this->badgePath))) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/'.$this->badgePath))
                ->as('Badge-'.$this->registration->reference.'.pdf')
                ->withMime('application/pdf');
        }
        if ($this->invoicePath && file_exists(storage_path('app/public/'.$this->invoicePath))) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/'.$this->invoicePath))
                ->as('Facture-'.$this->registration->reference.'.pdf')
                ->withMime('application/pdf');
        }
        return $attachments;
    }
}

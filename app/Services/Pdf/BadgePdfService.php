<?php

namespace App\Services\Pdf;

use App\Models\Registration;
use App\Settings\BrandingSettings;
use App\Settings\EventSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class BadgePdfService
{
    /**
     * Génère le badge PDF d'une inscription et le retourne en bytes.
     */
    public function generate(Registration $registration): string
    {
        $registration->loadMissing(['participant', 'category']);

        $qrPayload = $this->signQrPayload($registration);
        $qrPng = $this->renderQrPng($qrPayload);

        $event = app(EventSettings::class);
        $branding = app(BrandingSettings::class);

        $pdf = Pdf::loadView('pdfs.badge', [
            'registration' => $registration,
            'participant' => $registration->participant,
            'category' => $registration->category,
            'event' => $event,
            'branding' => $branding,
            'qrDataUri' => 'data:image/png;base64,'.base64_encode($qrPng),
        ])
            ->setPaper('a6', 'portrait')
            ->setOption('isRemoteEnabled', true);

        return $pdf->output();
    }

    /**
     * Sauvegarde le PDF sur le disque et retourne le chemin relatif.
     */
    public function store(Registration $registration): string
    {
        $bytes = $this->generate($registration);
        $path = sprintf('badges/%s.pdf', $registration->reference);
        Storage::disk('public')->put($path, $bytes);

        $registration->update([
            'badge_generated' => true,
            'badge_generated_at' => now(),
            'badge_path' => $path,
        ]);

        return $path;
    }

    /**
     * Construit la charge utile du QR avec signature HMAC anti-falsification.
     */
    public function signQrPayload(Registration $registration): string
    {
        $payload = [
            'r' => $registration->reference,
            't' => $registration->qr_token,
            'e' => $registration->participant->email,
        ];
        $body = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $body, config('app.key'));

        return 'CONGRESIA|'.$body.'|'.substr($signature, 0, 32);
    }

    /**
     * Vérifie un QR scanné et retourne la Registration si valide.
     */
    public function verifyQrPayload(string $payload): ?Registration
    {
        $parts = explode('|', $payload);
        if (count($parts) !== 3 || $parts[0] !== 'CONGRESIA') {
            return null;
        }

        $body = $parts[1];
        $signature = $parts[2];
        $expected = substr(hash_hmac('sha256', $body, config('app.key')), 0, 32);

        if (! hash_equals($expected, $signature)) {
            return null;
        }

        $data = json_decode(base64_decode($body), true);
        if (! is_array($data) || empty($data['r'])) {
            return null;
        }

        return Registration::with(['participant', 'category'])
            ->where('reference', $data['r'])
            ->where('qr_token', $data['t'] ?? '__none__')
            ->first();
    }

    protected function renderQrPng(string $data): string
    {
        $builder = new Builder(
            writer: new PngWriter(),
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 360,
            margin: 10,
        );

        return $builder->build()->getString();
    }
}

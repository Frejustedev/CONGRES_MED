<?php

use App\Models\Participant;
use App\Models\Registration;
use App\Models\RegistrationCategory;
use App\Services\Pdf\BadgePdfService;

it('signs and verifies a QR payload', function () {
    $category = RegistrationCategory::factory()->create();
    $participant = Participant::factory()->create();
    $registration = Registration::factory()->create([
        'participant_id' => $participant->id,
        'category_id' => $category->id,
        'qr_token' => 'abc123abc123abc123abc123abc123abc123',
        'status' => 'confirmed',
    ]);

    $service = app(BadgePdfService::class);
    $payload = $service->signQrPayload($registration);

    expect($payload)->toStartWith('CONGRESIA|');

    $verified = $service->verifyQrPayload($payload);
    expect($verified)->not->toBeNull();
    expect($verified->id)->toBe($registration->id);
});

it('rejects a tampered QR payload', function () {
    $category = RegistrationCategory::factory()->create();
    $participant = Participant::factory()->create();
    $registration = Registration::factory()->create([
        'participant_id' => $participant->id,
        'category_id' => $category->id,
        'qr_token' => 'xyz789xyz789xyz789xyz789xyz789xyz789',
        'status' => 'confirmed',
    ]);

    $service = app(BadgePdfService::class);
    $payload = $service->signQrPayload($registration);

    // Tamper the signature (last 32 chars)
    $tampered = substr($payload, 0, -32).str_repeat('a', 32);

    expect($service->verifyQrPayload($tampered))->toBeNull();
});

it('rejects a QR with wrong prefix', function () {
    $service = app(BadgePdfService::class);
    expect($service->verifyQrPayload('FAKE|abc|123'))->toBeNull();
});

<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\Registration;
use App\Services\Pdf\BadgePdfService;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct(protected BadgePdfService $badge)
    {
    }

    /**
     * Valide un payload QR scanné et enregistre l'Attendance.
     *
     * @return array{ok: bool, message: string, registration?: Registration, attendance?: Attendance, duplicate?: bool}
     */
    public function recordScan(
        string $qrPayload,
        ?int $sessionId = null,
        ?int $roomId = null,
        string $scanPoint = 'entrance',
        ?int $scannedByUserId = null,
        ?string $syncUuid = null,
        bool $isOfflineSync = false,
    ): array {
        $registration = $this->badge->verifyQrPayload($qrPayload);

        if (! $registration) {
            return ['ok' => false, 'message' => 'QR code invalide ou falsifié.'];
        }

        if ($registration->status !== 'confirmed') {
            return [
                'ok' => false,
                'message' => 'Inscription non confirmée (statut : '.$registration->status.').',
                'registration' => $registration,
            ];
        }

        // Idempotency : si syncUuid existe déjà, on retourne le scan existant
        if ($syncUuid && $existing = Attendance::where('sync_uuid', $syncUuid)->first()) {
            return [
                'ok' => true,
                'message' => 'Scan déjà enregistré (idempotent).',
                'attendance' => $existing,
                'registration' => $registration,
                'duplicate' => true,
            ];
        }

        // Anti-double scan : même session dans les 30s
        if ($sessionId) {
            $recent = Attendance::where('registration_id', $registration->id)
                ->where('session_id', $sessionId)
                ->where('scanned_at', '>=', now()->subSeconds(30))
                ->first();
            if ($recent) {
                return [
                    'ok' => true,
                    'message' => 'Déjà scanné pour cette session il y a quelques secondes.',
                    'attendance' => $recent,
                    'registration' => $registration,
                    'duplicate' => true,
                ];
            }
        }

        $attendance = DB::transaction(function () use ($registration, $sessionId, $roomId, $scanPoint, $scannedByUserId, $syncUuid, $isOfflineSync) {
            $attendance = Attendance::create([
                'registration_id' => $registration->id,
                'session_id' => $sessionId,
                'room_id' => $roomId,
                'scanned_by_user_id' => $scannedByUserId,
                'scan_point' => $scanPoint,
                'scanned_at' => $isOfflineSync && $syncUuid ? now() : now(),
                'scanner_ip' => request()?->ip(),
                'scanner_device' => substr((string) request()?->userAgent(), 0, 240),
                'is_offline_sync' => $isOfflineSync,
                'sync_uuid' => $syncUuid,
            ]);

            // Marquer l'entrée principale si scan point=entrance
            if ($scanPoint === 'entrance' && ! $registration->checked_in_at) {
                $registration->update([
                    'checked_in_at' => $attendance->scanned_at,
                    'checked_in_by_user_id' => $scannedByUserId,
                ]);
            }

            return $attendance;
        });

        return [
            'ok' => true,
            'message' => 'Scan validé.',
            'attendance' => $attendance,
            'registration' => $registration,
        ];
    }
}

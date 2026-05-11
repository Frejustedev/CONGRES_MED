<?php

namespace App\Services\Cme;

use App\Models\Attendance;
use App\Models\CmeCredit;
use App\Models\ProgramSession;
use App\Models\Registration;

class CmeService
{
    /**
     * Attribue les crédits CME pour une registration en fonction de ses attendances.
     */
    public function attributeCredits(Registration $registration): int
    {
        $attendedSessionIds = Attendance::where('registration_id', $registration->id)
            ->whereNotNull('session_id')
            ->pluck('session_id')
            ->unique();

        $sessions = ProgramSession::whereIn('id', $attendedSessionIds)
            ->where('cme_credits', '>', 0)
            ->get();

        $count = 0;
        foreach ($sessions as $session) {
            CmeCredit::firstOrCreate(
                ['registration_id' => $registration->id, 'session_id' => $session->id],
                [
                    'category' => 'cme',
                    'credits' => $session->cme_credits,
                    'earned_at' => Attendance::where('registration_id', $registration->id)
                        ->where('session_id', $session->id)
                        ->orderBy('scanned_at')
                        ->first()?->scanned_at ?? now(),
                    'validated' => true,
                ],
            );
            $count++;
        }

        return $count;
    }

    /**
     * Recalcule les crédits CME pour toutes les registrations confirmées.
     */
    public function recomputeAll(): int
    {
        $registrations = Registration::where('status', 'confirmed')->get();
        $total = 0;
        foreach ($registrations as $r) {
            $total += $this->attributeCredits($r);
        }
        return $total;
    }
}

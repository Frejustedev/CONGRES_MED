<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ProgramSession;
use App\Models\Room;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScanController extends Controller
{
    public function __construct(protected AttendanceService $attendance)
    {
    }

    public function show(): Response
    {
        return Inertia::render('Staff/Scanner', [
            'rooms' => Room::where('is_active', true)->orderBy('display_order')->get(['id', 'slug', 'name', 'color']),
            'sessions' => ProgramSession::where('is_published', true)
                ->where('starts_at', '>=', now()->subHours(2))
                ->where('starts_at', '<=', now()->addHours(12))
                ->orderBy('starts_at')
                ->get(['id', 'slug', 'title', 'starts_at', 'ends_at', 'room_id'])
                ->map(fn ($s) => [
                    'id' => $s->id,
                    'title' => $s->title,
                    'starts_at' => $s->starts_at->format('H:i'),
                    'ends_at' => $s->ends_at->format('H:i'),
                    'room_id' => $s->room_id,
                ]),
            'recentScans' => Attendance::with(['registration.participant', 'session:id,title'])
                ->where('scanned_by_user_id', auth()->id())
                ->latest('scanned_at')
                ->limit(20)
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'participant' => $a->registration?->participant?->fullName() ?? 'Inconnu',
                    'reference' => $a->registration?->reference,
                    'session' => $a->session?->title,
                    'scan_point' => $a->scan_point,
                    'scanned_at' => $a->scanned_at->format('H:i:s'),
                ]),
        ]);
    }

    public function validateScan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'qr_payload' => ['required', 'string', 'max:1000'],
            'session_id' => ['nullable', 'exists:program_sessions,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'scan_point' => ['required', 'in:entrance,room,exit,gala,workshop'],
            'sync_uuid' => ['nullable', 'string', 'max:36'],
            'is_offline_sync' => ['boolean'],
        ]);

        $result = $this->attendance->recordScan(
            qrPayload: $validated['qr_payload'],
            sessionId: $validated['session_id'] ?? null,
            roomId: $validated['room_id'] ?? null,
            scanPoint: $validated['scan_point'],
            scannedByUserId: $request->user()?->id,
            syncUuid: $validated['sync_uuid'] ?? null,
            isOfflineSync: $validated['is_offline_sync'] ?? false,
        );

        if (! $result['ok']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        $reg = $result['registration'];

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'duplicate' => $result['duplicate'] ?? false,
            'participant' => [
                'name' => $reg->participant->fullName(),
                'reference' => $reg->reference,
                'category' => $reg->category->name,
                'organization' => $reg->participant->organization,
                'photo_url' => $reg->participant->avatar_path ? '/storage/'.$reg->participant->avatar_path : null,
            ],
            'attendance_id' => $result['attendance']?->id,
        ]);
    }
}

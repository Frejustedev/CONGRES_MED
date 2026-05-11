<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abstrakt;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $totalRegistrations = Registration::count();
        $confirmedRegistrations = Registration::where('status', 'confirmed')->count();
        $pendingRegistrations = Registration::where('status', 'awaiting_payment')->count();
        $revenue = (float) Payment::where('status', 'completed')->sum('amount');
        $checkedIn = Registration::whereNotNull('checked_in_at')->count();

        $abstracts = Abstrakt::query()
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $registrationsByDay = Registration::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $registrationsByCategory = Registration::query()
            ->selectRaw('registration_categories.name as category, COUNT(*) as total')
            ->join('registration_categories', 'registrations.category_id', '=', 'registration_categories.id')
            ->groupBy('registration_categories.name')
            ->get();

        $registrationsByCountry = Registration::query()
            ->selectRaw('participants.country as country, COUNT(*) as total')
            ->join('participants', 'registrations.participant_id', '=', 'participants.id')
            ->whereNotNull('participants.country')
            ->groupBy('participants.country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $paymentsByGateway = Payment::query()
            ->where('status', 'completed')
            ->selectRaw('gateway, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('gateway')
            ->get();

        $scansToday = Attendance::whereDate('scanned_at', today())->count();

        return Inertia::render('Admin/Dashboard', [
            'kpis' => [
                'total_registrations' => $totalRegistrations,
                'confirmed_registrations' => $confirmedRegistrations,
                'pending_registrations' => $pendingRegistrations,
                'revenue' => $revenue,
                'currency' => 'XOF',
                'checked_in' => $checkedIn,
                'check_in_rate' => $confirmedRegistrations > 0 ? round(($checkedIn / $confirmedRegistrations) * 100, 1) : 0,
                'scans_today' => $scansToday,
                'abstracts_total' => Abstrakt::count(),
                'abstracts_submitted' => $abstracts['submitted'] ?? 0,
                'abstracts_under_review' => $abstracts['under_review'] ?? 0,
                'abstracts_accepted' => $abstracts['accepted'] ?? 0,
                'abstracts_rejected' => $abstracts['rejected'] ?? 0,
            ],
            'charts' => [
                'registrations_by_day' => $registrationsByDay,
                'registrations_by_category' => $registrationsByCategory,
                'registrations_by_country' => $registrationsByCountry,
                'payments_by_gateway' => $paymentsByGateway,
            ],
            'recent_registrations' => Registration::with('participant', 'category')
                ->latest()
                ->limit(10)
                ->get()
                ->map(fn ($r) => [
                    'reference' => $r->reference,
                    'participant' => $r->participant->fullName(),
                    'category' => $r->category->name,
                    'status' => $r->status,
                    'amount_due' => (float) $r->amount_due,
                    'amount_paid' => (float) $r->amount_paid,
                    'currency' => $r->currency,
                    'created_at' => $r->created_at->toIso8601String(),
                ]),
        ]);
    }
}

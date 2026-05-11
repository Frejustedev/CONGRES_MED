<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Inertia\Inertia;
use Inertia\Response;

class SponsorsController extends Controller
{
    public function __invoke(): Response
    {
        $sponsorsByTier = Sponsor::query()
            ->where('is_published', true)
            ->orderBy('display_order')
            ->get(['id', 'slug', 'name', 'tier', 'logo_path', 'description', 'website'])
            ->groupBy('tier');

        $tierOrder = ['platinum', 'gold', 'silver', 'bronze', 'partner', 'institutional', 'media'];
        $tiers = collect($tierOrder)
            ->filter(fn ($tier) => $sponsorsByTier->has($tier))
            ->map(fn ($tier) => [
                'key' => $tier,
                'label' => match ($tier) {
                    'platinum' => 'Platine',
                    'gold' => 'Or',
                    'silver' => 'Argent',
                    'bronze' => 'Bronze',
                    'partner' => 'Partenaires',
                    'institutional' => 'Institutionnels',
                    'media' => 'Médias',
                    default => ucfirst($tier),
                },
                'sponsors' => $sponsorsByTier[$tier]->values(),
            ])
            ->values();

        return Inertia::render('Public/Sponsors', [
            'tiers' => $tiers,
            'totalCount' => $sponsorsByTier->flatten()->count(),
        ]);
    }
}

<?php

namespace App\Services\Pdf;

use App\Models\Abstrakt;
use App\Settings\BrandingSettings;
use App\Settings\EventSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AbstractsBookletService
{
    public function generate(?string $category = null): string
    {
        $event = app(EventSettings::class);
        $branding = app(BrandingSettings::class);

        $query = Abstrakt::with(['authors', 'thematicArea'])
            ->where('is_published', true)
            ->orderBy('thematic_area_id')
            ->orderBy('title');

        if ($category) {
            $query->whereHas('thematicArea', fn ($q) => $q->where('slug', $category));
        }

        $abstracts = $query->get();

        $byTheme = $abstracts->groupBy(fn ($a) => $a->thematicArea?->name ?? 'Autres');

        $pdf = Pdf::loadView('pdfs.abstracts-booklet', [
            'abstracts' => $abstracts,
            'byTheme' => $byTheme,
            'event' => $event,
            'branding' => $branding,
            'totalCount' => $abstracts->count(),
            'generatedAt' => now(),
        ])->setPaper('a4');

        $path = sprintf('booklets/abstracts-%s.pdf', now()->format('Y-m-d-His'));
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}

<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function __invoke(): Response
    {
        $categories = Faq::where('is_published', true)
            ->orderBy('display_order')
            ->get(['id', 'category', 'question', 'answer'])
            ->groupBy('category')
            ->map(fn ($items, $category) => [
                'key' => $category,
                'label' => match ($category) {
                    'inscription' => 'Inscription & paiement',
                    'abstracts' => 'Soumission de résumés',
                    'logistique' => 'Logistique & attestations',
                    'pratique' => 'Informations pratiques',
                    default => ucfirst($category),
                },
                'items' => $items->values(),
            ])
            ->values();

        return Inertia::render('Public/Faq', [
            'categories' => $categories,
        ]);
    }
}

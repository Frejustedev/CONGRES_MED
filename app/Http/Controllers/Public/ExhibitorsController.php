<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use Inertia\Inertia;
use Inertia\Response;

class ExhibitorsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Public/Exhibitors', [
            'exhibitors' => Exhibitor::query()
                ->where('is_published', true)
                ->orderBy('display_order')
                ->orderBy('booth_number')
                ->get(['id', 'slug', 'name', 'booth_number', 'booth_size', 'logo_path', 'description', 'website', 'product_tags']),
        ]);
    }
}

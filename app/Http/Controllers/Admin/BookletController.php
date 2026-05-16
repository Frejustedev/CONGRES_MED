<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Pdf\AbstractsBookletService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookletController extends Controller
{
    public function __invoke(Request $request, AbstractsBookletService $service): BinaryFileResponse
    {
        $path = $service->generate($request->query('category'));

        return response()->download(
            storage_path('app/public/'.$path),
            'livret-abstracts-'.now()->format('Y-m-d').'.pdf',
            ['Content-Type' => 'application/pdf'],
        )->deleteFileAfterSend();
    }
}

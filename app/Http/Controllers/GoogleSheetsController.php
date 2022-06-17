<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{
    public function get(Request $request, GoogleSheetsService $service) {

        $service->appendSheet([
            [
                '6',
                'RRR'
            ]
        ]
        );

        $data = $service->readSheet();
        return response()->json($data);
    }
}

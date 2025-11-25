<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AndroidAppManualController extends Controller
{
    public function index(): View
    {
        $manualData = json_decode(file_get_contents(base_path('android_app_manual.json')), true);

        return view('android-app-manual', [
            'manualData' => $manualData,
        ]);
    }
}

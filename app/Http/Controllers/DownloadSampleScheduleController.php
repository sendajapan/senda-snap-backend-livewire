<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadSampleScheduleController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $filePath = base_path('sample_schedule.xlsx');

        return response()->download($filePath, 'sample_schedule.xlsx');
    }
}

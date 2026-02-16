<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exports\PublicSchedulesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ShipmentSchedulePublicExportController extends Controller
{
    /**
     * Export filtered public schedules to Excel.
     */
    public function __invoke(Request $request): BinaryFileResponse
    {
        $filters = ['is_public' => true];
        if ($request->filled('search')) {
            $filters['search'] = $request->input('search');
        }
        if ($request->filled('vessel')) {
            $filters['vessel_name'] = $request->input('vessel');
        }
        if ($request->filled('voyage')) {
            $filters['voyage_no'] = $request->input('voyage');
        }
        if ($request->filled('carrier_id')) {
            $filters['carrier_id'] = (int) $request->input('carrier_id');
        }
        if ($request->filled('start_port_id')) {
            $filters['start_port_id'] = (int) $request->input('start_port_id');
        }
        if ($request->filled('end_port_id')) {
            $filters['end_port_id'] = (int) $request->input('end_port_id');
        }

        return Excel::download(
            new PublicSchedulesExport($filters),
            'schedules.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}

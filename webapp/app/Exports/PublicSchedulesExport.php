<?php

declare(strict_types=1);

namespace App\Exports;

use App\Services\ScheduleService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PublicSchedulesExport implements FromCollection, WithHeadings
{
    /**
     * Excel column headers (must match import template for round-trip).
     */
    public const HEADINGS = [
        'Vessel',
        'Voyage No',
        'Carrier 1',
        'Start Port',
        'End Port',
        'ETA',
        'ETD',
        'Status',
        'Comment',
    ];

    public function __construct(
        private readonly array $filters
    ) {}

    public function collection(): Collection
    {
        $scheduleService = app(ScheduleService::class);
        $schedules = $scheduleService->listAll($this->filters);

        return $schedules->map(function ($schedule) {
            return [
                $schedule->vessel_name,
                $schedule->voyage_no,
                $schedule->carrier1?->line_name ?? '',
                $schedule->startPort?->port_name ?? '',
                $schedule->endPort?->port_name ?? '',
                $schedule->eta?->format('Y-m-d') ?? '',
                $schedule->etd?->format('Y-m-d') ?? '',
                $schedule->status ?? 'Waiting',
                $schedule->comment ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return self::HEADINGS;
    }
}

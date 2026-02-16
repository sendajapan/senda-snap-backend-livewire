<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Imports\ShipmentScheduleImport;
use App\Services\ScheduleService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class PublicImport extends Component
{
    use WithFileUploads;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $excelFile = null;

    /** @var array<int, array<string, string>> Parsed rows (canonical keys), editable in table */
    public array $parsedRows = [];

    /** @var array<int, int> Row index => 1 when that row has been successfully imported */
    public array $importedRows = [];

    /** @var array<int, array<string, list<string>>> Row index => field => list of error messages */
    public array $rowErrors = [];

    public ?string $creatorName = null;

    public string $step = 'upload'; // 'upload' | 'table' | 'done'

    public int $importedCount = 0;

    public int $failedCount = 0;

    public bool $showPreview = false;

    public bool $isParsing = false;

    /** @var array<int, array<string, string>> */
    public array $previewNodes = [];

    /** @var array<int, array<string, string>> */
    public array $previewConnections = [];

    protected function rules(): array
    {
        return [
            'excelFile' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ];
    }

    protected function messages(): array
    {
        return [
            'excelFile.required' => __('Please select an Excel file to upload.'),
            'excelFile.mimes' => __('The file must be an Excel file (.xlsx or .xls).'),
            'excelFile.max' => __('The file may not be greater than 10 MB.'),
        ];
    }

    public function mount(): void
    {
        if (auth()->check()) {
            $this->creatorName = auth()->user()->name;
        } else {
            $saved = session('public_schedule_creator_name');
            $this->creatorName = ($saved !== null && $saved !== '') ? trim((string) $saved) : 'Guest';
        }
    }

    public function updatedExcelFile(): void
    {
        $this->validateOnly('excelFile');
        $this->parseFile();
    }

    public function parseFile(): void
    {
        $this->isParsing = true;
        $this->validate([
            'excelFile' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ]);

        try {
            $path = $this->excelFile->getRealPath();
            $import = new ShipmentScheduleImport;
            $sheets = Excel::toArray($import, $path);
            $rows = $sheets[0] ?? []; // first sheet
            $this->parsedRows = [];
            foreach ($rows as $rawRow) {
                $mapped = ShipmentScheduleImport::mapRowToCanonical(is_array($rawRow) ? $rawRow : []);
                // Skip completely empty rows
                if (trim(implode('', $mapped)) === '') {
                    continue;
                }
                $this->parsedRows[] = $mapped;
            }
            $this->importedRows = [];
            $this->rowErrors = [];
            $this->step = 'table';
            $this->dispatch('import-render-ready');
        } catch (\Throwable $e) {
            $this->addError('excelFile', $e->getMessage());
        } finally {
            $this->isParsing = false;
        }
    }

    /**
     * Group canonical rows by (shipping_line, vessel_name, voyage_no, pol, etd). Returns [ groupKey => [ rowIndex => row ], ... ].
     * Only includes rows not already in importedRows.
     *
     * @return array<string, array<int, array<string, string>>>
     */
    protected function groupParsedRows(): array
    {
        $groups = [];
        foreach ($this->parsedRows as $index => $row) {
            if (isset($this->importedRows[$index])) {
                continue;
            }
            $key = ShipmentScheduleImport::groupKeyForRow($row);
            if (trim((string) ($row['shipping_line'] ?? '')) === '' && trim((string) ($row['vessel_name'] ?? '')) === '' && trim((string) ($row['voyage_no'] ?? '')) === '') {
                continue;
            }
            $groups[$key][$index] = $row;
        }

        return $groups;
    }

    public function saveRow(int $index, ScheduleService $scheduleService): void
    {
        $this->rowErrors[$index] = [];
        if (! isset($this->parsedRows[$index])) {
            return;
        }
        $row = $this->parsedRows[$index];
        $userId = auth()->id();
        $creatorName = $this->creatorName;
        try {
            $scheduleService->createFromImportGroup([$row], $userId, $creatorName);
            $this->importedRows[$index] = 1;
            $this->dispatch('notify', message: __('Row :n imported successfully.', ['n' => $index + 1]), type: 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->rowErrors[$index] = $e->errors();
        } catch (\Throwable $e) {
            $this->rowErrors[$index] = ['_' => [$e->getMessage()]];
        }
    }

    public function confirmImportAll(ScheduleService $scheduleService): void
    {
        $this->importedCount = 0;
        $this->failedCount = 0;
        $groups = $this->groupParsedRows();
        $userId = auth()->id();
        $creatorName = $this->creatorName;

        foreach ($groups as $groupKey => $indexedRows) {
            $indices = array_keys($indexedRows);
            $rows = array_values($indexedRows);
            $firstIndex = $indices[0];
            $this->rowErrors[$firstIndex] = [];
            try {
                $scheduleService->createFromImportGroup($rows, $userId, $creatorName);
                foreach ($indices as $i) {
                    $this->importedRows[$i] = 1;
                }
                $this->importedCount++;
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->rowErrors[$firstIndex] = $e->errors();
                $this->failedCount++;
            } catch (\Throwable) {
                $this->rowErrors[$firstIndex] = ['_' => [__('An error occurred.')]];
                $this->failedCount++;
            }
        }

        $this->step = 'done';
        $msg = __(':imported imported.', ['imported' => $this->importedCount]);
        if ($this->failedCount > 0) {
            $msg .= ' '.__(':failed failed.', ['failed' => $this->failedCount]);
        }
        $this->dispatch('notify', message: $msg, type: $this->failedCount > 0 ? 'warning' : 'success');
    }

    public function backToUpload(): void
    {
        $this->step = 'upload';
        $this->excelFile = null;
        $this->parsedRows = [];
        $this->importedRows = [];
        $this->rowErrors = [];
    }

    public function removeRow(int $index): void
    {
        if (! isset($this->parsedRows[$index])) {
            return;
        }
        unset($this->parsedRows[$index]);
        $this->parsedRows = array_values($this->parsedRows);

        $newImported = [];
        foreach ($this->importedRows as $oldIdx => $v) {
            if ($oldIdx < $index) {
                $newImported[$oldIdx] = $v;
            } elseif ($oldIdx > $index) {
                $newImported[$oldIdx - 1] = $v;
            }
        }
        $this->importedRows = $newImported;

        $newErrors = [];
        foreach ($this->rowErrors as $oldIdx => $v) {
            if ($oldIdx < $index) {
                $newErrors[$oldIdx] = $v;
            } elseif ($oldIdx > $index) {
                $newErrors[$oldIdx - 1] = $v;
            }
        }
        $this->rowErrors = $newErrors;
    }

    public function previewRow(int $index): void
    {
        if (! isset($this->parsedRows[$index])) {
            return;
        }

        $targetKey = ShipmentScheduleImport::groupKeyForRow($this->parsedRows[$index]);
        $start = $index;
        while ($start > 0 && ShipmentScheduleImport::groupKeyForRow($this->parsedRows[$start - 1]) === $targetKey) {
            $start--;
        }

        $end = $index;
        $lastIndex = count($this->parsedRows) - 1;
        while ($end < $lastIndex && ShipmentScheduleImport::groupKeyForRow($this->parsedRows[$end + 1]) === $targetKey) {
            $end++;
        }

        $groupRows = [];
        for ($i = $start; $i <= $end; $i++) {
            $groupRows[] = $this->parsedRows[$i];
        }

        $this->buildPreviewFlow($groupRows);
        $this->showPreview = true;
    }

    public function closePreview(): void
    {
        $this->showPreview = false;
    }

    /**
     * @param  array<int, array<string, string>>  $groupRows
     */
    protected function buildPreviewFlow(array $groupRows): void
    {
        $this->previewNodes = [];
        $this->previewConnections = [];

        if (count($groupRows) === 0) {
            return;
        }

        $first = $groupRows[0];
        $nodes = [[
            'port' => trim((string) ($first['pol'] ?? '')) ?: (string) __('Start Port'),
            'event' => 'ETD',
            'date' => trim((string) ($first['etd'] ?? '')) ?: 'N/A',
            'type' => 'start',
        ]];

        $rowCount = count($groupRows);
        foreach ($groupRows as $i => $row) {
            $pod = trim((string) ($row['pod'] ?? ''));
            if ($pod === '') {
                continue;
            }
            $nodes[] = [
                'port' => $pod,
                'event' => 'ETA',
                'date' => trim((string) ($row['eta'] ?? '')) ?: 'N/A',
                'type' => $i === ($rowCount - 1) ? 'destination' : 'stopover',
            ];
        }

        $this->previewNodes = $nodes;

        for ($i = 0; $i < count($nodes) - 1; $i++) {
            $from = $nodes[$i];
            $to = $nodes[$i + 1];
            $this->previewConnections[] = [
                'label' => sprintf(
                    '%s (%s: %s) -> %s (%s: %s)',
                    $from['port'],
                    $from['event'],
                    $from['date'],
                    $to['port'],
                    $to['event'],
                    $to['date']
                ),
            ];
        }
    }

    public function render(): View
    {
        return view('livewire.shipment-schedule.public-import')
            ->layout('components.layouts.public', [
                'title' => __('Import Shipment Schedule'),
                'backRoute' => 'shipment-schedule.public',
            ]);
    }
}

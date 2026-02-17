<div class="flex flex-1 flex-col gap-4 pb-24 md:pb-0 pl-[max(1.5rem,env(safe-area-inset-left))] pr-[max(1.5rem,env(safe-area-inset-right))] sm:px-4 md:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1920px] flex flex-1 flex-col gap-4 text-sm">
        <x-page-header
            :title="__('Import Shipment Schedule')"
            :description="__('Upload an Excel file to import schedules. You can review and edit rows before saving.')"
            variant="gray">
            <x-slot:icon>
                <flux:icon.arrow-up-tray class="h-7 w-7 text-white" />
            </x-slot:icon>
            <x-slot:actions>
                <flux:button href="{{ route('shipment-schedule.public') }}" variant="outline" icon="arrow-left" wire:navigate>
                    {{ __('Back to Schedule') }}
                </flux:button>
            </x-slot:actions>
        </x-page-header>

        @if($step === 'upload')
            <x-table-card variant="gray">
                <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-900/40 dark:bg-blue-900/20">
                    <div class="flex items-start gap-3">
                        <flux:icon.information-circle class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                                {{ __('Please use the sample Excel format for successful import.') }}
                            </p>
                            <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                                {{ __('Download and review the sample file to ensure your data matches the required format.') }}
                            </p>
                            <div class="mt-2">
                                <flux:button href="{{ route('shipment-schedule.public.download-sample') }}" variant="ghost" size="sm" icon="arrow-down-tray" class="text-blue-600 dark:text-blue-400">
                                    {{ __('Download Sample Excel Format') }}
                                </flux:button>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes importLogSlideIn {
                        from { opacity: 0; transform: translateY(8px); }
                        to   { opacity: 1; transform: translateY(0); }
                    }
                    .import-log-line { animation: importLogSlideIn 0.25s ease-out both; }
                </style>
                <form wire:submit="parseFile" class="space-y-4"
                    x-data="{
                        uploading: false,
                        smoothProgress: 0,
                        isParsing: $wire.entangle('isParsing').live,
                        progressStage: $wire.entangle('progressStage').live,
                        parsingTicker: null,
                        smoothTicker: null,
                        logs: [],
                        logTimers: [],
                        logCounter: 0,
                        get visibleLogs() { return this.logs.slice(-2); },
                        init() {
                            this.$watch('isParsing', value => {
                                if (!value && this.parsingTicker) {
                                    clearInterval(this.parsingTicker);
                                    this.parsingTicker = null;
                                }
                            });
                        },
                        timestamp() {
                            const d = new Date();
                            return d.toLocaleTimeString('en-GB', { hour12: false }) + '.' + String(d.getMilliseconds()).padStart(3, '0');
                        },
                        pushLog(msg, type) {
                            this.logCounter++;
                            this.logs.push({ id: this.logCounter, time: this.timestamp(), msg, type: type || 'info' });
                        },
                        clearLogTimers() {
                            this.logTimers.forEach(t => clearTimeout(t));
                            this.logTimers = [];
                        },
                        startSmoothProgress() {
                            if (this.smoothTicker) clearInterval(this.smoothTicker);
                            this.clearLogTimers();
                            this.smoothProgress = 0;
                            this.uploading = true;
                            this.logs = [];
                            this.logCounter = 0;

                            this.pushLog('Establishing secure connection to upload service', 'info');

                            const steps = [
                                [350,  'Transmitting Excel file to server — verifying file integrity', 'upload'],
                                [800,  'File received — initializing spreadsheet parser engine', 'read'],
                                [1300, 'Parsing workbook structure and extracting row data', 'extract'],
                                [1700, 'Cross-referencing entries with shipping database records', 'map'],
                                [2100, 'Validating schedule fields — checking dates and port codes', 'map'],
                                [2500, 'Building confirmation table — preparing editable preview', 'generate'],
                                [2900, 'Finalizing import — rendering confirmation interface', 'generate'],
                            ];
                            steps.forEach(([delay, msg, type]) => {
                                this.logTimers.push(setTimeout(() => this.pushLog(msg, type), delay));
                            });

                            const target = 78;
                            const duration = 2000;
                            const startTime = Date.now();
                            this.smoothTicker = setInterval(() => {
                                const elapsed = Date.now() - startTime;
                                const t = Math.min(1, elapsed / duration);
                                const ease = t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
                                this.smoothProgress = target * ease;
                                if (t >= 1) {
                                    this.smoothProgress = target;
                                    clearInterval(this.smoothTicker);
                                    this.smoothTicker = null;
                                }
                            }, 16);
                        },
                        handleDrop(event) {
                            const files = event.dataTransfer.files;
                            if (files.length > 0) {
                                const input = document.getElementById('excel-upload');
                                const dt = new DataTransfer();
                                dt.items.add(files[0]);
                                input.files = dt.files;
                                input.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        }
                    }"
                    x-on:livewire-upload-start="startSmoothProgress()"
                    x-on:livewire-upload-finish="uploading = false; pushLog('Upload complete — processing server response', 'success')"
                    x-on:livewire-upload-error="uploading = false; smoothProgress = 0; clearLogTimers(); pushLog('Connection interrupted — upload failed', 'error'); if (smoothTicker) { clearInterval(smoothTicker); smoothTicker = null; }">
                    <flux:field>
                        <flux:label>{{ __('Excel file') }}</flux:label>
                        <label
                            for="excel-upload"
                            x-data="{ dragging: false }"
                            x-on:dragover.prevent="dragging = true"
                            x-on:dragleave.prevent="dragging = false"
                            x-on:drop.prevent="dragging = false; handleDrop($event)"
                            class="mt-1 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 px-6 py-10 transition-colors hover:border-gray-400 dark:hover:border-gray-500"
                            :class="dragging ? 'border-cyan-500 bg-cyan-50/50 dark:bg-cyan-900/20' : ''">
                            <input
                                type="file"
                                wire:model="excelFile"
                                accept=".xlsx,.xls"
                                class="sr-only"
                                id="excel-upload">
                            <flux:icon.document-arrow-up class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Drag and drop your file here, or') }}
                            </p>
                            <span class="mt-2">
                                <flux:button type="button" variant="outline" size="sm" onclick="document.getElementById('excel-upload').click()">
                                    {{ __('Browse') }}
                                </flux:button>
                            </span>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                                {{ __('.xlsx or .xls, max 10 MB') }}
                            </p>
                            <div x-show="uploading || isParsing" x-cloak class="mt-4 w-full max-w-lg" x-transition>
                                <div class="flex items-center justify-between gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span x-show="!isParsing">{{ __('Uploading…') }}</span>
                                    <span x-show="isParsing">{{ __('Processing…') }}</span>
                                    <span x-text="Math.round(smoothProgress) + '%'">0%</span>
                                </div>
                                <div class="mt-1 h-2 w-full overflow-hidden bg-gray-200 dark:bg-gray-700" role="progressbar" :aria-valuenow="Math.round(smoothProgress)" aria-valuemin="0" aria-valuemax="100">
                                    <div class="relative h-full overflow-hidden bg-cyan-500 dark:bg-cyan-400 transition-[width] duration-200 ease-out"
                                        :style="'width: ' + smoothProgress + '%'">
                                        <span class="upload-progress-shimmer absolute inset-0 block h-full w-full" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div x-show="logs.length > 0" class="mt-3 w-full overflow-hidden rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 font-mono text-xs">
                                    <template x-for="log in visibleLogs" :key="log.id">
                                        <div class="import-log-line flex items-start gap-2 px-3 py-1.5 border-b border-gray-100 dark:border-gray-800 last:border-b-0">
                                            <span class="shrink-0 font-semibold text-cyan-600 dark:text-cyan-400" x-text="'[' + log.time + ']'"></span>
                                            <span class="truncate" :class="{
                                                'text-blue-600 dark:text-blue-400': log.type === 'upload',
                                                'text-amber-600 dark:text-amber-400': log.type === 'read',
                                                'text-violet-600 dark:text-violet-400': log.type === 'extract',
                                                'text-indigo-600 dark:text-indigo-400': log.type === 'map',
                                                'text-emerald-600 dark:text-emerald-400': log.type === 'generate' || log.type === 'success',
                                                'text-red-600 dark:text-red-400': log.type === 'error',
                                                'text-gray-500 dark:text-gray-400': log.type === 'info',
                                            }" x-text="log.msg"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </label>
                        @error('excelFile')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </form>
            </x-table-card>
        @endif

        @if($step === 'table')
            <x-table-card variant="gray">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                    <flux:heading size="lg">{{ __('Review and edit') }}</flux:heading>
                    <div class="flex flex-wrap gap-2">
                        <flux:button wire:click="confirmImportAll" variant="primary" icon="arrow-down-tray" class="cursor-pointer !bg-emerald-500 hover:!bg-emerald-600 !border-emerald-500 hover:!border-emerald-600">
                            {{ __('Confirm import all') }}
                        </flux:button>
                    </div>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-[1200px] table-auto whitespace-nowrap border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="sticky top-0 z-20 bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12 border-r border-gray-200 dark:border-gray-700">{{ __('S/N') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Shipping Line') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Vessel Name') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Voy No.') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('POL') }}</th>
                                <th scope="col" class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ETD') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('POD') }}</th>
                                <th scope="col" class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ETA') }}</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Comment') }}</th>
                                <th scope="col" class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-l border-gray-200 dark:border-gray-700">{{ __('Preview') }}</th>
                                <th scope="col" class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-l border-gray-200 dark:border-gray-700">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $lastGroupKey = null;
                                $groupStripIndex = -1;
                                $groupKeysByIndex = [];
                                $rowSpanByStartIndex = [];
                                $previousGroupKey = null;
                                $currentStartIndex = null;
                                $currentSpan = 0;

                                foreach ($parsedRows as $idx => $r) {
                                    $currentGroupKey = \App\Imports\ShipmentScheduleImport::groupKeyForRow($r);
                                    $groupKeysByIndex[$idx] = $currentGroupKey;

                                    if ($currentGroupKey !== $previousGroupKey) {
                                        if ($currentStartIndex !== null) {
                                            $rowSpanByStartIndex[$currentStartIndex] = $currentSpan;
                                        }
                                        $currentStartIndex = $idx;
                                        $currentSpan = 1;
                                        $previousGroupKey = $currentGroupKey;
                                    } else {
                                        $currentSpan++;
                                    }
                                }

                                if ($currentStartIndex !== null) {
                                    $rowSpanByStartIndex[$currentStartIndex] = $currentSpan;
                                }
                            @endphp
                            @foreach($parsedRows as $index => $row)
                                @php
                                    $groupKey = $groupKeysByIndex[$index];
                                    if ($groupKey !== $lastGroupKey) {
                                        $groupStripIndex++;
                                        $lastGroupKey = $groupKey;
                                    }
                                    $isEvenGroup = ($groupStripIndex % 2) === 0;
                                    $isFirstInGroup = array_key_exists($index, $rowSpanByStartIndex);
                                    $groupSize = $rowSpanByStartIndex[$index] ?? 1;
                                @endphp
                                <tr wire:key="row-{{ $index }}" class="text-sm @if(isset($importedRows[$index])) !bg-green-100 dark:!bg-green-900/30 @elseif($isEvenGroup) !bg-white dark:!bg-gray-900 @else !bg-gray-100 dark:!bg-gray-800 @endif">
                                    <td class="px-3 py-1.5 whitespace-nowrap text-center text-gray-600 dark:text-gray-400 font-medium border-r border-gray-200 dark:border-gray-700">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">
                                        <flux:input wire:model.blur="parsedRows.{{ $index }}.shipping_line" size="sm" class="!rounded-none text-sm {{ isset($rowErrors[$index]['shipping_line']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['shipping_line']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['shipping_line']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">
                                        <flux:input wire:model.blur="parsedRows.{{ $index }}.vessel_name" size="sm" class="!rounded-none text-sm {{ isset($rowErrors[$index]['vessel_name']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['vessel_name']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['vessel_name']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">
                                        <flux:input wire:model.blur="parsedRows.{{ $index }}.voyage_no" size="sm" class="!rounded-none text-sm {{ isset($rowErrors[$index]['voyage_no']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['voyage_no']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['voyage_no']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">
                                        <flux:input wire:model.blur="parsedRows.{{ $index }}.pol" size="sm" class="!rounded-none text-sm {{ isset($rowErrors[$index]['pol']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['pol']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['pol']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap text-center">
                                        <input type="date" wire:model.blur="parsedRows.{{ $index }}.etd" class="text-sm text-center border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 px-2 py-1 w-full {{ isset($rowErrors[$index]['etd']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['etd']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['etd']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">
                                        <flux:input wire:model.blur="parsedRows.{{ $index }}.pod" size="sm" class="!rounded-none text-sm {{ isset($rowErrors[$index]['pod']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['pod']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['pod']) }}</flux:error>
                                        @endif
                                    </td>
                                    <td class="px-3 py-1.5 whitespace-nowrap text-center">
                                        <input type="date" wire:model.blur="parsedRows.{{ $index }}.eta" class="text-sm text-center border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 px-2 py-1 w-full {{ isset($rowErrors[$index]['eta']) ? 'border-red-500' : '' }}" />
                                        @if(isset($rowErrors[$index]['eta']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['eta']) }}</flux:error>
                                        @endif
                                    </td>
                                    @if($isFirstInGroup)
                                        <td class="px-3 py-1.5 align-top border-l border-gray-200 dark:border-gray-700" rowspan="{{ $groupSize }}">
                                            <flux:textarea wire:model.blur="parsedRows.{{ $index }}.comment" rows="{{ max(2, (int) $groupSize) }}" class="!rounded-none min-w-[120px] w-full resize-y text-sm" placeholder="{{ __('Comment') }}" />
                                        </td>
                                    @endif
                                    @if($isFirstInGroup)
                                        <td class="px-3 py-1.5 whitespace-nowrap text-center align-top border-l border-gray-200 dark:border-gray-700" rowspan="{{ $groupSize }}">
                                            <flux:button wire:click="previewRow({{ $index }})" size="sm" variant="primary" icon="share" class="cursor-pointer">
                                                {{ __('Preview') }}
                                            </flux:button>
                                        </td>
                                    @endif
                                    <td class="px-3 py-1.5 whitespace-nowrap text-center border-l border-gray-200 dark:border-gray-700">
                                        <div class="flex flex-nowrap items-center justify-center gap-2">
                                            @if(isset($importedRows[$index]))
                                                <flux:badge color="green" size="sm">{{ __('Imported') }}</flux:badge>
                                            @else
                                                <button wire:click="removeRow({{ $index }})" wire:confirm="{{ __('Remove this row?') }}" class="cursor-pointer inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 text-sm font-medium rounded-md text-red-600 dark:text-red-400 border border-red-400 dark:border-red-500 hover:bg-red-500 hover:text-white dark:hover:bg-red-500 dark:hover:text-white transition-colors">
                                                    <flux:icon.trash class="h-4 w-4" />
                                                    <span>{{ __('Delete') }}</span>
                                                </button>
                                            @endif
                                        </div>
                                        @if(isset($rowErrors[$index]['_']))
                                            <flux:error>{{ implode(' ', $rowErrors[$index]['_']) }}</flux:error>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($parsedRows) === 0)
                    <p class="py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No rows to display.') }}</p>
                @endif
            </x-table-card>

            @php
                    $previewModalW = 1080;
                    $previewCardW = 220;
                    $previewCardH = 116;
                    $previewGap = 40;
                    $previewBridgeH = 56;
            @endphp
            <div
                x-data="{ previewOpen: $wire.entangle('showPreview').live }"
                x-cloak
                x-show="previewOpen"
                x-transition.opacity.duration.150ms
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-900" style="width: {{ $previewModalW }}px;">
                        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                            <div>
                                <flux:heading size="lg">{{ __('Route Preview') }}</flux:heading>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Roadmap from start port to destination with stopovers') }}</p>
                            </div>
                            <flux:button type="button" @click="previewOpen = false" variant="ghost" icon="x-mark" />
                        </div>

                        <div class="overflow-y-auto overflow-x-hidden py-6" style="max-height: 75vh;">
                            @if(count($previewNodes) > 0)
                                @php
                                    $cardsPerRow = 4;
                                    $previewRows = array_chunk($previewNodes, $cardsPerRow, true);
                                    $totalRows = count($previewRows);
                                @endphp
                                <div class="flex flex-col items-center" style="width: {{ $previewModalW }}px;">
                                    @foreach($previewRows as $rowIndex => $rowNodes)
                                        @php
                                            $thisRowN = count($rowNodes);
                                            $thisRowWidth = $thisRowN * $previewCardW + ($thisRowN - 1) * $previewGap;
                                        @endphp
                                        <div class="flex items-center" style="width: {{ $thisRowWidth }}px;">
                                            @foreach($rowNodes as $nodeIndex => $node)
                                                @php
                                                    $isStart = ($node['type'] ?? '') === 'start';
                                                    $isDestination = ($node['type'] ?? '') === 'destination';
                                                    $nodeColor = $isStart
                                                        ? 'from-emerald-500 to-emerald-600 dark:from-emerald-400 dark:to-emerald-500'
                                                        : ($isDestination
                                                            ? 'from-blue-500 to-indigo-600 dark:from-blue-400 dark:to-indigo-500'
                                                            : 'from-amber-500 to-orange-600 dark:from-amber-400 dark:to-orange-500');
                                                    $cardBorder = $isStart
                                                        ? 'border-emerald-300/70 dark:border-emerald-700/60'
                                                        : ($isDestination ? 'border-blue-300/70 dark:border-blue-700/60' : 'border-amber-300/70 dark:border-amber-700/60');
                                                @endphp
                                                {{-- Node card (fixed size) --}}
                                                <div class="flex shrink-0 flex-col items-center text-center" style="width: {{ $previewCardW }}px;">
                                                    <div class="flex h-full w-full flex-col rounded-xl border {{ $cardBorder }} bg-white p-3 shadow-sm transition-transform duration-200 hover:-translate-y-0.5 dark:bg-gray-800/80" style="min-height: {{ $previewCardH }}px;">
                                                        <span class="mx-auto mb-2 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-xs font-semibold text-white {{ $nodeColor }}">
                                                            {{ $nodeIndex + 1 }}
                                                        </span>
                                                        <p class="line-clamp-2 flex-1 text-xs font-semibold text-gray-800 dark:text-gray-100">{{ $node['port'] }}</p>
                                                        <p class="mt-1 shrink-0 text-[11px] font-medium text-gray-500 dark:text-gray-400">
                                                            {{ $node['event'] }}: {{ $node['date'] }}
                                                        </p>
                                                        <span class="mt-2 inline-flex shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide
                                                            {{ $isStart
                                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                                                : ($isDestination
                                                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
                                                                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300') }}">
                                                            {{ $isStart ? __('Start') : ($isDestination ? __('Destination') : __('Stopover')) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Horizontal connector (fixed width) --}}
                                                @if(!$loop->last)
                                                    <div class="group/conn relative shrink-0 flex h-16 items-center justify-center" style="width: {{ $previewGap }}px;">
                                                        <svg class="absolute inset-0 h-full w-full" viewBox="0 0 {{ $previewGap }} 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <defs>
                                                                <marker id="arrowH{{ $nodeIndex }}" markerWidth="8" markerHeight="6" refX="7" refY="3" orient="auto">
                                                                    <path d="M0 0 L8 3 L0 6 Z" class="fill-cyan-500 dark:fill-cyan-400" />
                                                                </marker>
                                                            </defs>
                                                            <line x1="4" y1="32" x2="{{ $previewGap - 4 }}" y2="32"
                                                                class="route-svg-line stroke-cyan-400 dark:stroke-cyan-500"
                                                                stroke-width="2" stroke-dasharray="6 4"
                                                                marker-end="url(#arrowH{{ $nodeIndex }})" />
                                                        </svg>
                                                        <span class="pointer-events-none absolute -top-8 left-1/2 z-30 hidden -translate-x-1/2 whitespace-nowrap rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[11px] font-medium text-gray-700 shadow-lg group-hover/conn:block dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                                            {{ $previewConnections[$nodeIndex]['label'] ?? '' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        {{-- Row bridge connector: path in pixel coordinates (modal = 1080px) --}}
                                        @if($rowIndex < $totalRows - 1)
                                            @php
                                                $rowNodeKeys = array_keys($rowNodes);
                                                $rowLastNodeIndex = end($rowNodeKeys);
                                                $rowBridgeTooltip = $previewConnections[$rowLastNodeIndex]['label'] ?? '';
                                                $n1 = count($rowNodes);
                                                $n2 = count($previewRows[$rowIndex + 1]);
                                                $row1Px = $n1 * $previewCardW + ($n1 - 1) * $previewGap;
                                                $row2Px = $n2 * $previewCardW + ($n2 - 1) * $previewGap;
                                                $row1Offset = (int) (($previewModalW - $row1Px) / 2);
                                                $row2Offset = (int) (($previewModalW - $row2Px) / 2);
                                                $startX = $row1Offset + ($n1 - 1) * ($previewCardW + $previewGap) + $previewCardW / 2;
                                                $endX = $row2Offset + $previewCardW / 2;
                                                $midY = (int) ($previewBridgeH / 2);
                                                $curveX = (int) (($startX + $endX) / 2);
                                            @endphp
                                            <div class="group/rowconn relative flex shrink-0 items-center justify-center" style="width: {{ $previewModalW }}px; height: {{ $previewBridgeH }}px;">
                                                <svg class="block" width="{{ $previewModalW }}" height="{{ $previewBridgeH }}" viewBox="0 0 {{ $previewModalW }} {{ $previewBridgeH }}" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <marker id="arrowBridge{{ $rowIndex }}" markerWidth="8" markerHeight="6" refX="4" refY="3" orient="auto">
                                                            <path d="M0 0 L8 3 L0 6 Z" class="fill-cyan-500 dark:fill-cyan-400" />
                                                        </marker>
                                                    </defs>
                                                    <path d="M {{ $startX }} 0 L {{ $startX }} 12 Q {{ $startX }} {{ $midY }}, {{ $curveX }} {{ $midY }} L {{ $endX + 40 }} {{ $midY }} Q {{ $endX }} {{ $midY }}, {{ $endX }} {{ $previewBridgeH - 12 }} L {{ $endX }} {{ $previewBridgeH }}"
                                                        class="route-svg-line stroke-cyan-400 dark:stroke-cyan-500"
                                                        stroke-width="2" stroke-dasharray="6 4" fill="none"
                                                        marker-end="url(#arrowBridge{{ $rowIndex }})" />
                                                </svg>
                                                <span class="pointer-events-none absolute top-0 left-1/2 z-30 hidden -translate-x-1/2 whitespace-nowrap rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[11px] font-medium text-gray-700 shadow-lg group-hover/rowconn:block dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                                    {{ $rowBridgeTooltip }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="py-10 text-center text-gray-500 dark:text-gray-400">{{ __('No route data available for preview.') }}</p>
                            @endif
                        </div>

                        <div class="flex justify-end border-t border-gray-200 px-5 py-3 dark:border-gray-700">
                            <flux:button type="button" @click="previewOpen = false" variant="primary">{{ __('Close') }}</flux:button>
                        </div>
                    </div>
            </div>
        @endif

        @if($step === 'done')
            <x-table-card variant="gray">
                <flux:heading size="lg" class="mb-2">{{ __('Import complete') }}</flux:heading>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __(':imported imported.', ['imported' => $importedCount]) }}
                    @if($failedCount > 0)
                        {{ __(':failed failed.', ['failed' => $failedCount]) }}
                    @endif
                </p>
                <div class="mt-4">
                    <flux:button href="{{ route('shipment-schedule.public') }}" variant="primary" wire:navigate>
                        {{ __('Back to Public Schedule') }}
                    </flux:button>
                </div>
            </x-table-card>
        @endif
    </div>
</div>

@php
    $totalUsers = \App\Models\User::count();
    $totalTasks = \App\Models\Task::count();
    $totalVehicles = \App\Models\Vehicle::count();

    $taskPending = \App\Models\Task::where('status', 'pending')->count();
    $taskRunning = \App\Models\Task::where('status', 'running')->count();
    $taskCompleted = \App\Models\Task::where('status', 'completed')->count();

    $vehiclePending = \App\Models\Vehicle::where('status', 'pending')->count();
    $vehicleInYard = \App\Models\Vehicle::where('status', 'in_yard')->count();
    $vehicleReady = \App\Models\Vehicle::where('status', 'ready')->count();
    $vehicleSold = \App\Models\Vehicle::where('status', 'sold')->count();
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-4">
        <!-- Welcome Header -->
        <div class="rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h1>
                    <p class="mt-2 text-gray-700">
                        {{ 'Today is ' . now()->format('jS, F, Y.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-4">
            <!-- Users Card -->
            <div class="group relative overflow-hidden shadow-lg rounded-2xl border bg-zink-200 dark:bg-zinc-900 dark:border-gray-200 p-6 transition-all hover:scale-100 hover:shadow-2xl">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-blue-300 dark:bg-white/10 backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-blue-400 dark:bg-white/5"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-accent">{{ __('Total Users') }}</p>
                            <h3 class="mt-2 text-4xl font-bold text-accent">{{ $totalUsers }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/20 p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-accent">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>{{ __('All registered users') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="group relative overflow-hidden shadow-lg rounded-2xl border bg-zink-200 dark:bg-zinc-900 dark:border-gray-200 p-6 transition-all hover:scale-100 hover:shadow-2xl">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-emerald-300 dark:bg-white/10 backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-emerald-400 dark:bg-white/5"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-accent">{{ __('Total Tasks') }}</p>
                            <h3 class="mt-2 text-4xl font-bold text-accent">{{ $totalTasks }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/20 p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-accent">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>{{ __('All tasks of users') }}</span>
                    </div>
                </div>
            </div>

            <!-- Vehicles Card -->
            <div class="group relative overflow-hidden shadow-lg rounded-2xl border bg-zink-200 dark:bg-zinc-900 dark:border-gray-200 p-6 transition-all hover:scale-100 hover:shadow-2xl">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-amber-300 dark:bg-white/10 backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-amber-400 dark:bg-white/5"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-accent">{{ __('Total Vehicles') }}</p>
                            <h3 class="mt-2 text-4xl font-bold text-accent">{{ $totalVehicles }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/20 p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-accent">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>{{ __('In inventory') }}</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden shadow-lg rounded-2xl border bg-zink-200 dark:bg-zinc-900 dark:border-gray-200 p-6 transition-all hover:scale-100 hover:shadow-2xl">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-red-300 dark:bg-white/10 backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-red-400 dark:bg-white/5"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-accent">{{ __('Total Notifications') }}</p>
                            <h3 class="mt-2 text-4xl font-bold text-accent">{{ $totalVehicles }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/20 p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-accent">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>{{ __('From Tasks') }}</span>
                    </div>
                </div>
            </div>

            {{--<div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-lg transition-all hover:scale-105 hover:shadow-2xl">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-white/10 backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-white/5"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-violet-100">{{ __('Total Vehicles') }}</p>
                            <h3 class="mt-2 text-4xl font-bold text-white">{{ $totalVehicles }}</h3>
                        </div>
                        <div class="rounded-xl bg-white/20 p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-violet-100">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('In inventory') }}</span>
                    </div>
                </div>
            </div>--}}
        </div>

        <!-- Charts Section -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Task Status Donut Chart -->
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Task Status') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Distribution of all tasks') }}</p>
                    </div>
                    <div
                        class="rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 p-3 dark:from-emerald-900 dark:to-teal-900">
                        <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <canvas id="taskChart" class="max-h-64"></canvas>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-between rounded-lg bg-amber-50 p-3 dark:bg-amber-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Pending') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $taskPending }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Running') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $taskRunning }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-emerald-500"></div>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Completed') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $taskCompleted }}</span>
                    </div>
                </div>
            </div>

            <!-- Vehicle Status Donut Chart -->
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Vehicle Status') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Current inventory status') }}</p>
                    </div>
                    <div
                        class="rounded-xl bg-gradient-to-br from-violet-100 to-purple-100 p-3 dark:from-violet-900 dark:to-purple-900">
                        <svg class="h-6 w-6 text-violet-600 dark:text-violet-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <canvas id="vehicleChart" class="max-h-64"></canvas>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-slate-500"></div>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Pending') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $vehiclePending }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-amber-50 p-3 dark:bg-amber-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('In Yard') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $vehicleInYard }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Ready') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $vehicleReady }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-emerald-500"></div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Sold') }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $vehicleSold }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Task Status Donut Chart
                const taskCtx = document.getElementById('taskChart').getContext('2d');
                new Chart(taskCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Running', 'Completed'],
                        datasets: [{
                            data: [{{ $taskPending }}, {{ $taskRunning }}, {{ $taskCompleted }}],
                            backgroundColor: [
                                'rgba(245, 158, 11, 0.8)',  // Amber
                                'rgba(59, 130, 246, 0.8)',  // Blue
                                'rgba(16, 185, 129, 0.8)',  // Emerald
                            ],
                            borderColor: [
                                'rgb(245, 158, 11)',
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        label += ` (${percentage}%)`;
                                        return label;
                                    }
                                }
                            }
                        },
                        cutout: '70%',
                    }
                });

                // Vehicle Status Donut Chart
                const vehicleCtx = document.getElementById('vehicleChart').getContext('2d');
                new Chart(vehicleCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'In Yard', 'Ready', 'Sold'],
                        datasets: [{
                            data: [{{ $vehiclePending }}, {{ $vehicleInYard }}, {{ $vehicleReady }}, {{ $vehicleSold }}],
                            backgroundColor: [
                                'rgba(100, 116, 139, 0.8)',  // Slate
                                'rgba(245, 158, 11, 0.8)',   // Amber
                                'rgba(59, 130, 246, 0.8)',   // Blue
                                'rgba(16, 185, 129, 0.8)',   // Emerald
                            ],
                            borderColor: [
                                'rgb(100, 116, 139)',
                                'rgb(245, 158, 11)',
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        label += ` (${percentage}%)`;
                                        return label;
                                    }
                                }
                            }
                        },
                        cutout: '70%',
                    }
                });
            });
        </script>
    @endpush
</x-layouts.app>

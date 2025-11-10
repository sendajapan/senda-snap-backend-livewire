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
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Main Welcome Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 p-8 shadow-xl">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex rounded-full bg-white/20 px-4 py-1 backdrop-blur-sm">
                        <span class="text-sm font-medium text-white">👋 Hello!</span>
                    </div>
                    <h1 class="text-3xl font-bold text-white">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-2 text-blue-100">{{ __('Welcome back to your dashboard') }}</p>
                </div>
            </div>

            <!-- Date & Time Card -->
            <div
                class="group relative overflow-hidden rounded-2xl border-2 border-gray-200 bg-white p-8 shadow-lg dark:border-gray-700 dark:bg-zinc-900">
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-16 w-16 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900">
                        <span
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">{{ now()->format('M') }}</span>
                        <span
                            class="text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ now()->format('d') }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ now()->format('l, Y') }}</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ now()->format('h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
            <!-- Users Card -->
            <x-stats-card :title="__('Total Users')" :count="$totalUsers" :description="__('All registered users')"
                topCircleColor="bg-blue-300" bottomCircleColor="bg-blue-400">
                <x-slot:icon>
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Tasks Card -->
            <x-stats-card :title="__('Total Tasks')" :count="$totalTasks" :description="__('All tasks of users')"
                topCircleColor="bg-emerald-300" bottomCircleColor="bg-emerald-400">
                <x-slot:icon>
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Vehicles Card -->
            <x-stats-card :title="__('Total Vehicles')" :count="$totalVehicles" :description="__('In inventory')"
                topCircleColor="bg-amber-300" bottomCircleColor="bg-amber-400">
                <x-slot:icon>
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Notifications Card -->
            <x-stats-card :title="__('Total Notifications')" :count="$totalVehicles" :description="__('From Tasks')"
                topCircleColor="bg-red-300" bottomCircleColor="bg-red-400">
                <x-slot:icon>
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            {{--<div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-lg transition-all hover:scale-105 hover:shadow-2xl">
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
                class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                <!-- Decorative Elements -->
                <div
                    class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-2xl">
                </div>
                <div
                    class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-2xl">
                </div>

                <div class="relative">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="h-1 w-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Task Status') }}</h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Distribution of all tasks') }}
                            </p>
                        </div>
                        <div
                            class="animate-pulse rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-4 shadow-lg shadow-emerald-500/50">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="relative flex items-center justify-center rounded-xl bg-white/50 p-6 backdrop-blur-sm dark:bg-gray-800/50">
                        <canvas id="taskChart" class="max-h-64"></canvas>
                    </div>

                    <div class="mt-6 space-y-3">
                        <div
                            class="group flex items-center justify-between rounded-xl border border-amber-200 bg-gradient-to-r from-amber-50 to-amber-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-amber-800/50 dark:from-amber-900/20 dark:to-amber-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-amber-500 shadow-lg shadow-amber-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-amber-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-amber-900 dark:text-amber-300">{{ __('Pending') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-amber-200 px-3 py-1 text-sm font-bold text-amber-900 dark:bg-amber-800 dark:text-amber-100">{{ $taskPending }}</span>
                        </div>

                        <div
                            class="group flex items-center justify-between rounded-xl border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-blue-800/50 dark:from-blue-900/20 dark:to-blue-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-blue-500 shadow-lg shadow-blue-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-blue-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-blue-900 dark:text-blue-300">{{ __('Running') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-blue-200 px-3 py-1 text-sm font-bold text-blue-900 dark:bg-blue-800 dark:text-blue-100">{{ $taskRunning }}</span>
                        </div>

                        <div
                            class="group flex items-center justify-between rounded-xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-emerald-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-emerald-800/50 dark:from-emerald-900/20 dark:to-emerald-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-emerald-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-emerald-900 dark:text-emerald-300">{{ __('Completed') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-emerald-200 px-3 py-1 text-sm font-bold text-emerald-900 dark:bg-emerald-800 dark:text-emerald-100">{{ $taskCompleted }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Status Donut Chart -->
            <div
                class="group relative overflow-hidden rounded-2xl border border-violet-200 bg-gradient-to-br from-white via-violet-50/30 to-purple-50/30 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl dark:border-violet-900/50 dark:from-gray-900 dark:via-violet-900/20 dark:to-purple-900/20">
                <!-- Decorative Elements -->
                <div
                    class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-violet-400/20 to-purple-400/20 blur-2xl">
                </div>
                <div
                    class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-purple-400/20 to-violet-400/20 blur-2xl">
                </div>

                <div class="relative">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="h-1 w-8 rounded-full bg-gradient-to-r from-violet-500 to-purple-500"></div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Vehicle Status') }}
                                </h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Current inventory status') }}
                            </p>
                        </div>
                        <div
                            class="animate-pulse rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-4 shadow-lg shadow-violet-500/50">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="relative flex items-center justify-center rounded-xl bg-white/50 p-6 backdrop-blur-sm dark:bg-gray-800/50">
                        <canvas id="vehicleChart" class="max-h-64"></canvas>
                    </div>

                    <div class="mt-6 space-y-3">
                        <div
                            class="group flex items-center justify-between rounded-xl border border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-slate-800/50 dark:from-slate-900/20 dark:to-slate-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-slate-500 shadow-lg shadow-slate-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-slate-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-slate-900 dark:text-slate-300">{{ __('Pending') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-slate-200 px-3 py-1 text-sm font-bold text-slate-900 dark:bg-slate-800 dark:text-slate-100">{{ $vehiclePending }}</span>
                        </div>

                        <div
                            class="group flex items-center justify-between rounded-xl border border-amber-200 bg-gradient-to-r from-amber-50 to-amber-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-amber-800/50 dark:from-amber-900/20 dark:to-amber-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-amber-500 shadow-lg shadow-amber-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-amber-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-amber-900 dark:text-amber-300">{{ __('In Yard') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-amber-200 px-3 py-1 text-sm font-bold text-amber-900 dark:bg-amber-800 dark:text-amber-100">{{ $vehicleInYard }}</span>
                        </div>

                        <div
                            class="group flex items-center justify-between rounded-xl border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-blue-800/50 dark:from-blue-900/20 dark:to-blue-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-blue-500 shadow-lg shadow-blue-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-blue-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-blue-900 dark:text-blue-300">{{ __('Ready') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-blue-200 px-3 py-1 text-sm font-bold text-blue-900 dark:bg-blue-800 dark:text-blue-100">{{ $vehicleReady }}</span>
                        </div>

                        <div
                            class="group flex items-center justify-between rounded-xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-emerald-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-emerald-800/50 dark:from-emerald-900/20 dark:to-emerald-800/10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="h-4 w-4 animate-pulse rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50">
                                    </div>
                                    <div
                                        class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-emerald-400 opacity-75">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-emerald-900 dark:text-emerald-300">{{ __('Sold') }}</span>
                            </div>
                            <span
                                class="rounded-lg bg-emerald-200 px-3 py-1 text-sm font-bold text-emerald-900 dark:bg-emerald-800 dark:text-emerald-100">{{ $vehicleSold }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            function initializeCharts() {
                // Destroy existing charts if they exist
                if (window.taskChart && typeof window.taskChart.destroy === 'function') {
                    window.taskChart.destroy();
                }
                if (window.vehicleChart && typeof window.vehicleChart.destroy === 'function') {
                    window.vehicleChart.destroy();
                }

                // Task Status Donut Chart
                const taskCtx = document.getElementById('taskChart');
                if (!taskCtx) return;

                window.taskChart = new Chart(taskCtx.getContext('2d'), {
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
                const vehicleCtx = document.getElementById('vehicleChart');
                if (!vehicleCtx) return;

                window.vehicleChart = new Chart(vehicleCtx.getContext('2d'), {
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
            }

            // Initialize charts on page load
            document.addEventListener('DOMContentLoaded', initializeCharts);

            // Re-initialize charts after Livewire navigation
            document.addEventListener('livewire:navigated', initializeCharts);
        </script>
    @endpush
</x-layouts.app>

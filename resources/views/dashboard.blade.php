@php
    $totalUsers = \App\Models\User::count();
    $totalTasks = \App\Models\Task::count();
    $totalShippingCompanies = \App\Models\ShipLine::count();
    $totalPorts = \App\Models\Port::count();

    $taskPending = \App\Models\Task::where('status', 'pending')->count();
    $taskRunning = \App\Models\Task::where('status', 'running')->count();
    $taskCompleted = \App\Models\Task::where('status', 'completed')->count();
    $taskCancelled = \App\Models\Task::where('status', 'cancelled')->count();

    $vehiclePending = \App\Models\Vehicle::where('status', 'pending')->count();
    $vehicleInYard = \App\Models\Vehicle::where('status', 'in_yard')->count();
    $vehicleReady = \App\Models\Vehicle::where('status', 'ready')->count();
    $vehicleSold = \App\Models\Vehicle::where('status', 'sold')->count();

    $upcomingTasks = \App\Models\Task::whereNotIn('status', ['completed', 'cancelled'])
        ->whereNotNull('work_date')
        ->where('work_date', '>=', now()->toDateString())
        ->with(['assignedUsers', 'creator'])
        ->orderBy('work_date', 'ASC')
        ->orderBy('work_time', 'ASC')
        ->limit(2)
        ->get();

    $members = \App\Models\User::with('vendor')->latest()->limit(5)->get();

    $adminCount = \App\Models\User::where('role', 'admin')->count();
    $managerCount = \App\Models\User::where('role', 'manager')->count();
    $employeeCount = \App\Models\User::where('role', 'employee')->count();
    $clientCount = \App\Models\User::where('role', 'client')->count();

    $nextUserTask = \App\Models\Task::whereNotIn('status', ['completed', 'cancelled'])
        ->whereNotNull('work_date')
        ->where('work_date', '>=', now()->toDateString())
        ->where('work_time', '>=', now()->toTimeString())
        ->where(function ($query) {
            $userId = auth()->id();
            $query->whereHas('assignedUsers', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
                ->orWhere('created_by', $userId);
        })
        ->with(['assignedUsers', 'creator'])
        ->orderBy('work_date', 'ASC')
        ->orderBy('work_time', 'ASC')
        ->first();
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="dashboard-container flex h-full w-full flex-1 flex-col gap-3 sm:gap-4 lg:gap-5 py-3 sm:py-4 lg:py-5">
        <!-- Welcome Header -->
        <div class="grid gap-3 sm:gap-4 lg:gap-5 lg:grid-cols-1 xl:grid-cols-2">
            <!-- Main Welcome Card - Simple Design -->
            <div class="welcome-card dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-blue-300/50 bg-gradient-to-br from-blue-600 to-cyan-600 p-4 sm:p-5 md:p-6 lg:p-7 shadow-xl shadow-blue-200/40 backdrop-blur-xl transition-all duration-300 hover:border-blue-400/60 hover:shadow-2xl hover:shadow-blue-300/50 dark:border-blue-800/50 dark:from-blue-700 dark:to-cyan-700 dark:shadow-blue-900/30 dark:hover:border-blue-700 dark:hover:shadow-blue-800/40">
                <!-- Content -->
                <div class="relative z-10">
                    <div class="mb-2 sm:mb-3 inline-flex rounded-full bg-white/25 px-2.5 sm:px-3 py-1 sm:py-1.5 backdrop-blur-md">
                        <span class="dashboard-text-xs text-xs sm:text-sm font-semibold text-white">👋 Hello!</span>
                    </div>
                    <h1 class="welcome-title dashboard-heading-xl text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white break-words">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="welcome-subtitle dashboard-text-base mt-1.5 sm:mt-2 text-sm sm:text-base md:text-lg font-medium text-white/90">{{ __('Welcome back to your dashboard') }}</p>
                </div>
            </div>

            <!-- Date & Time Card - Glass Morphism with Single Color -->
            <div class="dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-indigo-300/50 bg-white/60 p-4 sm:p-5 md:p-6 lg:p-7 shadow-xl shadow-indigo-200/40 backdrop-blur-xl transition-all duration-300 hover:border-indigo-400/60 hover:shadow-2xl hover:shadow-indigo-300/50 dark:border-indigo-800/50 dark:bg-gray-800/60 dark:shadow-indigo-900/30 dark:hover:border-indigo-700 dark:hover:shadow-indigo-800/40">
                <!-- Decorative blur circles - larger and more spread -->
                <div class="pointer-events-none absolute -right-6 sm:-right-12 -top-6 sm:-top-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-indigo-400/30 to-purple-400/30 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-6 sm:-bottom-12 -left-6 sm:-left-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-purple-400/30 to-indigo-400/30 blur-3xl"></div>
                <!-- Date & Time Section -->
                <div class="mb-2 flex items-center gap-2 sm:gap-3 border-b border-gray-200 pb-2 sm:pb-2.5 dark:border-gray-700">
                    <div class="flex h-11 w-11 lg:h-12 lg:w-12 flex-col items-center justify-center rounded-xl sm:rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 flex-shrink-0">
                        <span class="dashboard-text-xs text-[10px] sm:text-xs font-semibold text-indigo-600 dark:text-indigo-400">{{ now()->format('M') }}</span>
                        <span class="dashboard-text-base text-sm sm:text-base md:text-lg font-bold text-indigo-900 dark:text-indigo-100">{{ now()->format('d') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="dashboard-text-xs text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ now()->format('l, Y') }}</p>
                        <p class="dashboard-text-base text-sm sm:text-base md:text-lg font-bold text-gray-900 dark:text-white">{{ now()->format('h:i A') }}</p>
                    </div>
                </div>

                <!-- Next Upcoming Task -->
                @if($nextUserTask)
                    <div class="m-0 p-0">
                        <h5 class="dashboard-heading-md text-sm sm:text-base font-bold text-gray-900 dark:text-white break-words">{{ $nextUserTask->title }}</h5>
                        @if($nextUserTask->description)
                            <p class="dashboard-text-sm text-xs leading-relaxed text-gray-600 dark:text-gray-400 line-clamp-2 sm:line-clamp-3 mt-1">{{ $nextUserTask->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 pt-2">
                            <div class="flex items-center justify-between">
                                <flux:badge class="font-semibold" :color="match($nextUserTask->status) {
                            'completed' => 'green',
                            'running' => 'blue',
                            'cancelled' => 'red',
                            default => 'gray',
                            }" size="sm">
                                    {{ ucfirst($nextUserTask->status) }}
                                </flux:badge>
                            </div>
                            <flux:badge class="font-semibold" :color="match($nextUserTask->priority) {
                            'urgent' => 'red',
                            'high' => 'orange',
                            'medium' => 'yellow',
                            default => 'gray',
                            }" size="sm">
                                {{ ucfirst($nextUserTask->priority) }} Priority
                            </flux:badge>
                            @if($nextUserTask->work_date)
                                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium">{{ $nextUserTask->work_date->format('M d, Y') }}</span>
                                </div>
                            @endif
                            @if($nextUserTask->work_time)
                                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($nextUserTask->work_time)->format('h:i A') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="rounded-lg sm:rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-6 text-center dark:border-gray-700 dark:bg-gray-800/50">
                        <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('No upcoming tasks') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Cards - Enhanced with Blur and Colors -->
        <div class="grid gap-3 sm:gap-4 lg:gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4">
            <!-- Users Card -->
            <x-stats-card :title="__('Users')" :count="$totalUsers" :description="__('All registered users')" variant="blue">
                <x-slot:icon>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Tasks Card -->
            <x-stats-card :title="__('Tasks')" :count="$totalTasks" :description="__('All tasks of users')" variant="emerald">
                <x-slot:icon>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Shipping Companies Card -->
            <x-stats-card :title="__('Shipping Companies')" :count="$totalShippingCompanies" :description="__('Active shipping lines')" variant="amber">
                <x-slot:icon>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>

            <!-- Ports Card -->
            <x-stats-card :title="__('Ports')" :count="$totalPorts" :description="__('All registered ports')" variant="violet">
                <x-slot:icon>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
            </x-stats-card>
        </div>

        <!-- Charts Section -->
        <div class="grid gap-3 sm:gap-4 lg:gap-5 lg:grid-cols-1 xl:grid-cols-2">
            <!-- Task Status Donut Chart - Following Design System -->
            <div class="dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-emerald-300/50 bg-white/60 p-4 sm:p-5 lg:p-6 shadow-xl shadow-emerald-200/40 backdrop-blur-xl transition-all duration-300 hover:border-emerald-400/60 hover:shadow-2xl hover:shadow-emerald-300/50 dark:border-emerald-800/50 dark:bg-gray-800/60 dark:shadow-emerald-900/30 dark:hover:border-emerald-700 dark:hover:shadow-emerald-800/40">
                <!-- Decorative blur circles - larger and more spread -->
                <div class="pointer-events-none absolute -right-6 sm:-right-12 -top-6 sm:-top-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-emerald-400/30 to-teal-400/30 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-6 sm:-bottom-12 -left-6 sm:-left-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-teal-400/30 to-emerald-400/30 blur-3xl"></div>

                <div class="relative">
                    <div class="mb-3 sm:mb-4 lg:mb-5 flex items-center justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <div class="h-1 w-5 sm:w-6 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 flex-shrink-0"></div>
                                <h3 class="dashboard-heading-md text-base sm:text-lg font-bold text-gray-900 dark:text-white truncate">{{ __('Task Status') }}</h3>
                            </div>
                            <p class="dashboard-text-sm mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('Distribution of all tasks') }}</p>
                        </div>
                        <div class="animate-pulse rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-3 sm:p-4 shadow-lg shadow-emerald-500/50 flex-shrink-0">
                            <svg class="h-3 w-3 sm:h-4 sm:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Chart Container - Centered Layout -->
                    <div class="flex flex-col items-center gap-6 sm:gap-8 lg:flex-row lg:justify-center lg:items-center lg:gap-20  overflow-visible">
                        <!-- Chart Canvas -->
                        <div class="relative flex items-center justify-center w-full sm:w-auto overflow-visible">
                            <canvas id="taskChart" class="relative z-10 max-w-full"></canvas>
                        </div>

                        <!-- Status Labels - Compact Glass with Gradient Stroke -->
                        <div class="w-[220px] flex flex-col gap-2">
                            <!-- Pending -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-md border border-amber-400/50 bg-gradient-to-r from-amber-500/10 via-amber-400/5 to-white/40 px-1.5 sm:px-2 py-1.5 sm:py-2 shadow-xs shadow-amber-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-amber-400 hover:shadow-lg hover:shadow-amber-500/15 dark:border-amber-500/30 dark:from-amber-500/20 dark:via-amber-400/10 dark:to-gray-900/40">
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 rounded-full bg-amber-500/20 blur-xl transition-all group-hover:bg-amber-500/40"></div>
                                <div class="relative flex items-center gap-2">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg  bg-amber-500">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="dashboard-text-xs text-xs font-bold text-amber-900 dark:text-amber-200">{{ __('Pending') }}</span>
                                </div>
                                <span class="dashboard-text-xs text-xs font-bold text-amber-600 dark:text-amber-400" data-task-status="pending">{{ $taskPending }}</span>
                            </div>

                            <!-- Running -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-md border border-blue-400/50 bg-gradient-to-r from-blue-500/10 via-blue-400/5 to-white/40 px-1.5 sm:px-2 py-1.5 sm:py-2 shadow-xs shadow-blue-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/15 dark:border-blue-500/30 dark:from-blue-500/20 dark:via-blue-400/10 dark:to-gray-900/40">
                                <div class="absolute -left-3 top-1/2 h-12 w-12 -translate-y-1/2 rounded-full bg-blue-500/20 blur-xl transition-all group-hover:bg-blue-500/40"></div>
                                <div class="relative flex items-center gap-2">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-500">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </div>
                                    <span class="dashboard-text-xs text-xs font-bold text-blue-900 dark:text-blue-200">{{ __('Running') }}</span>
                                </div>
                                <span class="dashboard-text-xs text-xs font-bold text-blue-600 dark:text-blue-400" data-task-status="running">{{ $taskRunning }}</span>
                            </div>

                            <!-- Completed -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-md border border-emerald-400/50 bg-gradient-to-r from-emerald-500/10 via-emerald-400/5 to-white/40 px-1.5 sm:px-2 py-1.5 sm:py-2 shadow-xs shadow-emerald-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-500/15 dark:border-emerald-500/30 dark:from-emerald-500/20 dark:via-emerald-400/10 dark:to-gray-900/40">
                                <div class="absolute -left-3 top-1/2 h-12 w-12 -translate-y-1/2 rounded-full bg-emerald-500/20 blur-xl transition-all group-hover:bg-emerald-500/40"></div>
                                <div class="relative flex items-center gap-2">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-500">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="dashboard-text-xs text-xs font-bold text-emerald-900 dark:text-emerald-200">{{ __('Completed') }}</span>
                                </div>
                                <span class="dashboard-text-xs text-xs font-bold text-emerald-600 dark:text-emerald-400" data-task-status="completed">{{ $taskCompleted }}</span>
                            </div>

                            <!-- Cancelled -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-md border border-red-400/50 bg-gradient-to-r from-red-500/10 via-red-400/5 to-white/40 px-1.5 sm:px-2 py-1.5 sm:py-2 shadow-xs shadow-red-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-red-400 hover:shadow-lg hover:shadow-red-500/15 dark:border-red-500/30 dark:from-red-500/20 dark:via-red-400/10 dark:to-gray-900/40">
                                <div class="absolute -left-3 top-1/2 h-12 w-12 -translate-y-1/2 rounded-full bg-red-500/20 blur-xl transition-all group-hover:bg-red-500/40"></div>
                                <div class="relative flex items-center gap-2">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-red-500">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <span class="dashboard-text-xs text-xs font-bold text-red-900 dark:text-red-200">{{ __('Cancelled') }}</span>
                                </div>
                                <span class="dashboard-text-xs text-xs font-bold text-red-600 dark:text-red-400" data-task-status="cancelled">{{ $taskCancelled }}</span>
                            </div>

                        </div>
                    </div>

                    <!-- Upcoming Tasks Table -->
                    <div class="mt-3 sm:mt-4 lg:mt-5">
                        <h4 class="dashboard-heading-md my-1.5 sm:my-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Upcoming Tasks') }}</h4>
                        @if($upcomingTasks->count() > 0)
                            <!-- Table View: Large screens only -->
                            <div class="hidden lg:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                    <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                        @foreach($upcomingTasks as $task)
                                            <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
                                                <td class="whitespace-normal px-3 py-2 sm:px-4 sm:py-2.5 w-1/2">
                                                    <div class="flex flex-col">
                                                        <span class="dashboard-text-sm text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</span>
                                                        @if($task->description)
                                                            <span class="dashboard-text-xs mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-3">{{ $task->description }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-2 sm:px-4 sm:py-2.5">
                                                    <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }" size="sm" class="font-semibold">
                                                        {{ ucfirst($task->priority) }}
                                                    </flux:badge>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-2 sm:px-4 sm:py-2.5">
                                                    <flux:badge :color="match($task->status) { 'completed' => 'emerald', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }" size="sm" class="font-semibold">
                                                        {{ ucfirst($task->status) }}
                                                    </flux:badge>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-2 sm:px-4 sm:py-2.5">
                                                    @if($task->work_date)
                                                        <div class="flex flex-col gap-1">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                                <span class="dashboard-text-sm text-xs sm:text-sm text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</span>
                                                            </div>
                                                            @if($task->work_time)
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    <span class="dashboard-text-xs text-xs text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="dashboard-text-sm text-xs sm:text-sm text-gray-400 dark:text-gray-500">-</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-2 sm:px-4 sm:py-2.5">
                                                    @if($task->assignedUsers && $task->assignedUsers->count() > 0)
                                                        <div class="flex items-center gap-2">
                                                            <div class="flex -space-x-2">
                                                                @foreach($task->assignedUsers->take(3) as $user)
                                                                    <div class="relative h-7 w-7 flex-shrink-0" title="{{ $user->name }}">
                                                                        @if($user->avatar && $user->avatar_url)
                                                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-7 w-7 rounded-lg object-cover ring-2 ring-white dark:ring-gray-900" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                                            <div class="hidden h-7 w-7 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                                                                <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">{{ $user->initials() }}</span>
                                                                            </div>
                                                                        @else
                                                                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                                                                <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">{{ $user->initials() }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                                @if($task->assignedUsers->count() > 3)
                                                                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-500 ring-2 ring-white dark:ring-gray-900">
                                                                        <span class="text-xs font-bold text-white">+{{ $task->assignedUsers->count() - 3 }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                                                {{ $task->assignedUsers->pluck('name')->take(2)->implode(', ') }}
                                                                @if($task->assignedUsers->count() > 2)
                                                                    +{{ $task->assignedUsers->count() - 2 }} {{ __('more') }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-400 dark:text-gray-500">{{ __('Unassigned') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Vertical Stacked View: Medium screens and below -->
                            <div class="lg:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
                                <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                    @foreach($upcomingTasks as $task)
                                        <div class="p-2.5 sm:p-3 group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
                                            <!-- Title and Description -->
                                            <div class="mb-1.5 sm:mb-2">
                                                <h5 class="dashboard-text-sm text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</h5>
                                                @if($task->description)
                                                    <p class="dashboard-text-xs mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-3">{{ $task->description }}</p>
                                                @endif
                                            </div>
                                            <!-- All other info in one row -->
                                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                                <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }" size="sm" class="font-semibold">
                                                    {{ ucfirst($task->priority) }}
                                                </flux:badge>
                                                <flux:badge :color="match($task->status) { 'completed' => 'emerald', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }" size="sm" class="font-semibold">
                                                    {{ ucfirst($task->status) }}
                                                </flux:badge>
                                                @if($task->work_date)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $task->work_date->format('M d, Y') }}
                                                    </span>
                                                @endif
                                                @if($task->work_time)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}
                                                    </span>
                                                @endif
                                                @if($task->assignedUsers && $task->assignedUsers->count() > 0)
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                        {{ $task->assignedUsers->pluck('name')->take(2)->implode(', ') }}
                                                        @if($task->assignedUsers->count() > 2)
                                                            +{{ $task->assignedUsers->count() - 2 }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-gray-600 dark:text-gray-400">{{ __('Unassigned') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="rounded-xl border border-gray-200 bg-white/50 p-4 sm:p-6 text-center backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
                                <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <p class="mt-2 sm:mt-3 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('No upcoming tasks') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Members Card - Following Design System -->
            @if($members->count() > 0)
                <div class="dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-blue-300/50 bg-white/60 p-4 sm:p-5 lg:p-6 shadow-xl shadow-blue-200/40 backdrop-blur-xl transition-all duration-300 hover:border-blue-400/60 hover:shadow-2xl hover:shadow-blue-300/50 dark:border-blue-800/50 dark:bg-gray-800/60 dark:shadow-blue-900/30 dark:hover:border-blue-700 dark:hover:shadow-blue-800/40">
                    <!-- Decorative blur circles - larger and more spread -->
                    <div class="pointer-events-none absolute -right-6 sm:-right-12 -top-6 sm:-top-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-blue-400/30 to-cyan-400/30 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-6 sm:-bottom-12 -left-6 sm:-left-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-cyan-400/30 to-blue-400/30 blur-3xl"></div>

                    <div class="relative">
                        <div class="mb-3 sm:mb-4 lg:mb-5 flex items-center justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <div class="h-1 w-5 sm:w-6 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex-shrink-0"></div>
                                    <h3 class="dashboard-heading-md text-base sm:text-lg font-bold text-gray-900 dark:text-white truncate">{{ __('Members') }}</h3>
                                </div>
                                <p class="dashboard-text-sm mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('Team members overview') }}</p>
                            </div>
                            <div class="animate-pulse rounded-xl sm:rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 p-3 sm:p-4 shadow-lg shadow-blue-500/50 flex-shrink-0">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Role Counts Section - Neon Glow Cards Style -->
                        <div class="mb-3 sm:mb-4 lg:mb-5 grid grid-cols-2 gap-2 sm:gap-2.5 md:gap-3 md:grid-cols-4">
                            <!-- Admin Count -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-lg sm:rounded-xl border border-red-400/50 px-2 sm:px-2.5 md:px-3 py-1.5 sm:py-2 shadow-sm shadow-red-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.03] hover:border-red-400 hover:shadow-md hover:shadow-red-500/15 dark:border-red-500/30">
                                <div class="absolute -left-2 sm:-left-4 top-1/2 h-8 sm:h-16 w-8 sm:w-16 -translate-y-1/2 rounded-full bg-red-500/30 blur-2xl transition-all group-hover:bg-red-500/50"></div>
                                <div class="relative flex items-center gap-1.5 sm:gap-2 md:gap-3 min-w-0 flex-1">
                                    <div class="relative flex h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8 items-center justify-center rounded-lg bg-gradient-to-br from-red-400 to-rose-500 shadow-md shadow-red-500/20 flex-shrink-0">
                                        <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5 md:h-4 md:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="dashboard-text-sm text-xs sm:text-sm font-bold text-red-900 dark:text-red-200 block truncate">{{ __('Admin') }}</span>
                                        <p class="dashboard-text-xs text-[10px] sm:text-xs text-red-600/80 dark:text-red-400/70 truncate hidden sm:block">{{ __('Full Access') }}</p>
                                    </div>
                                </div>
                                <span class="relative rounded-full border border-red-400/50 px-1.5 sm:px-2 py-0.5 text-xs font-bold text-red-900 dark:text-red-200 shadow-sm shadow-red-500/10 backdrop-blur-xl flex-shrink-0">{{ $adminCount }}</span>
                            </div>

                            <!-- Manager Count -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-lg sm:rounded-xl border border-blue-400/50 px-2 sm:px-2.5 md:px-3 py-1.5 sm:py-2 shadow-sm shadow-blue-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.03] hover:border-blue-400 hover:shadow-md hover:shadow-blue-500/15 dark:border-blue-500/30">
                                <div class="absolute -left-2 sm:-left-4 top-1/2 h-8 sm:h-16 w-8 sm:w-16 -translate-y-1/2 rounded-full bg-blue-500/30 blur-2xl transition-all group-hover:bg-blue-500/50"></div>
                                <div class="relative flex items-center gap-1.5 sm:gap-2 md:gap-2.5 min-w-0 flex-1">
                                    <div class="relative flex h-5 w-5 sm:h-6 sm:w-6 md:h-7 md:w-7 items-center justify-center rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 shadow-md shadow-blue-500/20 flex-shrink-0">
                                        <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3 md:h-3.5 md:w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="dashboard-text-sm text-xs sm:text-sm font-bold text-blue-900 dark:text-blue-200 block truncate">{{ __('Manager') }}</span>
                                        <p class="dashboard-text-xs text-[10px] sm:text-xs text-blue-600/80 dark:text-blue-400/70 truncate hidden sm:block">{{ __('Team Lead') }}</p>
                                    </div>
                                </div>
                                <span class="relative rounded-full border border-blue-400/50 px-1.5 sm:px-2 py-0.5 text-xs font-bold text-blue-900 dark:text-blue-200 shadow-sm shadow-blue-500/10 backdrop-blur-xl flex-shrink-0">{{ $managerCount }}</span>
                            </div>

                            <!-- Employee Count -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-lg sm:rounded-xl border border-emerald-400/50 px-2 sm:px-2.5 md:px-3 py-1.5 sm:py-2 shadow-sm shadow-emerald-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.03] hover:border-emerald-400 hover:shadow-md hover:shadow-emerald-500/15 dark:border-emerald-500/30">
                                <div class="absolute -left-2 sm:-left-4 top-1/2 h-8 sm:h-16 w-8 sm:w-16 -translate-y-1/2 rounded-full bg-emerald-500/30 blur-2xl transition-all group-hover:bg-emerald-500/50"></div>
                                <div class="relative flex items-center gap-1.5 sm:gap-2 md:gap-2.5 min-w-0 flex-1">
                                    <div class="relative flex h-5 w-5 sm:h-6 sm:w-6 md:h-7 md:w-7 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-500 shadow-md shadow-emerald-500/20 flex-shrink-0">
                                        <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3 md:h-3.5 md:w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="dashboard-text-sm text-xs sm:text-sm font-bold text-emerald-900 dark:text-emerald-200 block truncate">{{ __('Employee') }}</span>
                                        <p class="dashboard-text-xs text-[10px] sm:text-xs text-emerald-600/80 dark:text-emerald-400/70 truncate hidden sm:block">{{ __('Staff') }}</p>
                                    </div>
                                </div>
                                <span class="relative rounded-full border border-emerald-400/50 px-1.5 sm:px-2 py-0.5 text-xs font-bold text-emerald-900 dark:text-emerald-200 shadow-sm shadow-emerald-500/10 backdrop-blur-xl flex-shrink-0">{{ $employeeCount }}</span>
                            </div>

                            <!-- Client Count -->
                            <div class="group relative flex items-center justify-between overflow-hidden rounded-lg sm:rounded-xl border border-violet-400/50 px-2 sm:px-2.5 md:px-3 py-1.5 sm:py-2 shadow-sm shadow-violet-500/10 backdrop-blur-xl transition-all duration-300 hover:scale-[1.03] hover:border-violet-400 hover:shadow-md hover:shadow-violet-500/15 dark:border-violet-500/30">
                                <div class="absolute -left-2 sm:-left-4 top-1/2 h-8 sm:h-16 w-8 sm:w-16 -translate-y-1/2 rounded-full bg-violet-500/30 blur-2xl transition-all group-hover:bg-violet-500/50"></div>
                                <div class="relative flex items-center gap-1.5 sm:gap-2 md:gap-2.5 min-w-0 flex-1">
                                    <div class="relative flex h-5 w-5 sm:h-6 sm:w-6 md:h-7 md:w-7 items-center justify-center rounded-lg bg-gradient-to-br from-violet-400 to-purple-500 shadow-md shadow-violet-500/20 flex-shrink-0">
                                        <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3 md:h-3.5 md:w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="dashboard-text-sm text-xs sm:text-sm font-bold text-violet-900 dark:text-violet-200 block truncate">{{ __('Client') }}</span>
                                        <p class="dashboard-text-xs text-[10px] sm:text-xs text-violet-600/80 dark:text-violet-400/70 truncate hidden sm:block">{{ __('Customer') }}</p>
                                    </div>
                                </div>
                                <span class="relative rounded-full border border-violet-400/50 px-1.5 sm:px-2 py-0.5 text-xs font-bold text-violet-900 dark:text-violet-200 shadow-sm shadow-violet-500/10 backdrop-blur-xl flex-shrink-0">{{ $clientCount }}</span>
                            </div>
                        </div>

                        <!-- Table View: Large screens only -->
                        <div class="hidden lg:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                    @foreach($members as $member)
                                        <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-cyan-50/50 dark:hover:from-blue-900/10 dark:hover:to-cyan-900/10">
                                            <td class="whitespace-nowrap p-2.5 sm:p-3 w-1/3">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative size-10 flex-shrink-0">
                                                        @if($member->avatar && $member->avatar_url)
                                                            <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="size-10 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                                                        @else
                                                            <div class="flex size-10 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800">
                                                                <span class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $member->initials() }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white bg-emerald-500 dark:border-gray-900"></div>
                                                    </div>
                                                    <div>
                                                        <div class="dashboard-text-sm text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</div>
                                                        <div class="dashboard-text-xs text-xs text-gray-500 dark:text-gray-400">
                                                            {{ __('Member since :date', ['date' => $member->created_at->format('M Y')]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-2.5 sm:p-3">
                                                <flux:badge class="font-semibold text-xs w-20 justify-center" :color="match($member->role) { 'admin' => 'red', 'manager' => 'blue', 'employee' => 'emerald', default => 'gray' }" size="sm">
                                                    {{ ucfirst($member->role) }}
                                                </flux:badge>
                                            </td>
                                            <td class="whitespace-nowrap p-2.5 sm:p-3">
                                                <div class="dashboard-text-xs text-xs text-gray-900 dark:text-white">
                                                    @if($member->vendor)
                                                        {{ $member->vendor->name }}
                                                    @else
                                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-2.5 sm:p-3">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="dashboard-text-sm text-xs sm:text-sm text-gray-900 dark:text-white">{{ $member->email }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vertical Stacked View: Medium screens and below -->
                        <div class="lg:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
                            <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @foreach($members as $member)
                                    <div class="p-2.5 sm:p-3 group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-cyan-50/50 dark:hover:from-blue-900/10 dark:hover:to-cyan-900/10">
                                        <div class="flex items-center gap-2.5 sm:gap-3 mb-1.5 sm:mb-2">
                                            <div class="relative size-10 flex-shrink-0">
                                                @if($member->avatar && $member->avatar_url)
                                                    <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="size-10 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                                                @else
                                                    <div class="flex size-10 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800">
                                                        <span class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $member->initials() }}</span>
                                                    </div>
                                                @endif
                                                <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white bg-emerald-500 dark:border-gray-900"></div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="dashboard-text-sm text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</div>
                                                <div class="dashboard-text-xs text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('Member since :date', ['date' => $member->created_at->format('M Y')]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs">
                                            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $member->email }}
                                            </span>
                                            <flux:badge :color="match($member->role) { 'admin' => 'red', 'manager' => 'blue', 'employee' => 'emerald', default => 'gray' }" size="sm" class="font-semibold">
                                                {{ ucfirst($member->role) }}
                                            </flux:badge>
                                            @if($member->vendor)
                                                <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $member->vendor->name }}
                                                </span>
                                            @endif
                                            @if($member->phone)
                                                <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    </svg>
                                                    {{ $member->phone }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            /* Modern flat chart styling */
            #taskChart {
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            async function fetchTaskStats() {
                try {
                    const response = await fetch('{{ route('dashboard.task-stats') }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch task stats');
                    }

                    const result = await response.json();
                    return result.data.stats;
                } catch (error) {
                    console.error('Error fetching task stats:', error);
                    // Fallback to initial server-rendered values
                    return {
                        pending: {{ $taskPending }},
                        running: {{ $taskRunning }},
                        completed: {{ $taskCompleted }},
                        cancelled: {{ $taskCancelled }}
                    };
                }
            }

            async function initializeCharts() {
                // Destroy existing charts if they exist
                if (window.taskChart && typeof window.taskChart.destroy === 'function') {
                    window.taskChart.destroy();
                }

                // Task Status Donut Chart
                const taskCtx = document.getElementById('taskChart');
                if (!taskCtx) return;

                // Fetch fresh task statistics
                const stats = await fetchTaskStats();

                // Update status count badges
                const pendingBadge = document.querySelector('[data-task-status="pending"]');
                const runningBadge = document.querySelector('[data-task-status="running"]');
                const completedBadge = document.querySelector('[data-task-status="completed"]');
                const cancelledBadge = document.querySelector('[data-task-status="cancelled"]');

                if (pendingBadge) pendingBadge.textContent = stats.pending;
                if (runningBadge) runningBadge.textContent = stats.running;
                if (completedBadge) completedBadge.textContent = stats.completed;
                if (cancelledBadge) cancelledBadge.textContent = stats.cancelled;

                // Modern flat colors - vibrant and clean
                const colors = {
                    amber: '#f59e0b',
                    blue: '#3b82f6',
                    emerald: '#10b981',
                    red: '#ef4444'
                };

                // Set canvas size for responsiveness
                const isMobile = window.innerWidth < 640;
                const isFHD = window.innerWidth >= 1920 && window.innerWidth < 2560;
                const is2KPlus = window.innerWidth >= 2560;

                let chartSize;
                if (isMobile) {
                    chartSize = 180;
                } else if (isFHD) {
                    chartSize = 200; // Smaller for FHD to fit everything
                } else if (is2KPlus) {
                    chartSize = 260; // Larger for 2K/4K
                } else {
                    chartSize = 240; // Default
                }

                taskCtx.style.width = chartSize + 'px';
                taskCtx.style.height = chartSize + 'px';
                taskCtx.width = chartSize;
                taskCtx.height = chartSize;

                window.taskChart = new Chart(taskCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Running', 'Completed', 'Cancelled'],
                        datasets: [{
                            data: [stats.pending, stats.running, stats.completed, stats.cancelled],
                            backgroundColor: [colors.amber, colors.blue, colors.emerald, colors.red],
                            borderColor: 'transparent',
                            borderWidth: 0,
                            hoverOffset: 8,
                            borderRadius: 6,
                            spacing: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: false,
                            duration: 800,
                            easing: 'easeOutQuart'
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true,
                                position: 'average',
                                xAlign: 'center',
                                yAlign: 'center',
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#e2e8f0',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                cornerRadius: 10,
                                padding: 12,
                                titleFont: {
                                    size: 13,
                                    weight: '600',
                                    family: "'Inter', sans-serif"
                                },
                                bodyFont: {
                                    size: 12,
                                    family: "'Inter', sans-serif"
                                },
                                displayColors: true,
                                boxWidth: 10,
                                boxHeight: 10,
                                boxPadding: 4,
                                usePointStyle: true,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label + ' Tasks';
                                    },
                                    label: function (context) {
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${value} tasks (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '78%',
                        radius: '100%',
                        rotation: -90,
                        circumference: 360,
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



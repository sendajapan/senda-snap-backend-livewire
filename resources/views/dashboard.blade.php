@php
    $totalUsers = \App\Models\User::count();
    $totalTasks = \App\Models\Task::count();
    $totalVehicles = \App\Models\Vehicle::count();

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
        ->limit(3)
        ->get();

    $members = \App\Models\User::latest()->limit(5)->get();

    $adminCount = \App\Models\User::where('role', 'admin')->count();
    $managerCount = \App\Models\User::where('role', 'manager')->count();
    $employeeCount = \App\Models\User::where('role', 'employee')->count();
    $clientCount = \App\Models\User::where('role', 'client')->count();

    $nextUserTask = \App\Models\Task::whereNotIn('status', ['completed', 'cancelled'])
        ->whereNotNull('work_date')
        ->where('work_date', '>=', now()->toDateString())
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
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Welcome Header -->
        <div class="grid gap-4 lg:grid-cols-1 xl:grid-cols-2">
            <!-- Main Welcome Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 p-8 shadow-xl">
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
            <div class="group relative overflow-hidden rounded-2xl border-1 border bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-zinc-900">
                <!-- Date & Time Section -->
                <div class="mb-2 flex items-center gap-4 border-b border-gray-200 pb-3 dark:border-gray-700">
                    <div class="flex h-14 w-14 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900">
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">{{ now()->format('M') }}</span>
                        <span class="text-xl font-bold text-indigo-900 dark:text-indigo-100">{{ now()->format('d') }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ now()->format('l, Y') }}</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ now()->format('h:i A') }}</p>
                    </div>
                </div>

                <!-- Next Upcoming Task -->
                @if($nextUserTask)
                    <div class="m-0 p-0">
                        <h5 class="text-md font-bold text-gray-900 dark:text-white">{{ $nextUserTask->title }}</h5>
                        @if($nextUserTask->description)
                            <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-400 line-clamp-4">{{ $nextUserTask->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-2 pt-2">
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
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800/50">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="mt-3 text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('No upcoming tasks') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            <!-- Users Card -->
            <x-stats-card :title="__('Total Users')" :count="$totalUsers" :description="__('All registered users')"
                          topCircleColor="bg-blue-300" bottomCircleColor="bg-blue-400">
                <x-slot:icon>
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
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
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
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
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
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
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('In inventory') }}</span>
                    </div>
                </div>
            </div>--}}
        </div>

        <!-- Charts Section -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Task Status Donut Chart -->
            <div class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                <!-- Decorative Elements -->
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-2xl"></div>
                <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-2xl"></div>

                <div class="relative">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="h-1 w-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Task Status') }}</h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Distribution of all tasks') }}</p>
                        </div>
                        <div class="animate-pulse rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-4 shadow-lg shadow-emerald-500/50">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Chart and Status List: Vertical on md/small, Horizontal on lg+ -->
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start">
                        <!-- Chart Canvas -->
                        <div class="relative flex flex-1 items-center justify-center p-2 rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                            <canvas id="taskChart" class="max-h-64"></canvas>
                        </div>

                        <!-- Status List -->
                        <div class="flex-1 space-y-2">
                            <div class="group flex items-center justify-between  border border-amber-200 bg-gradient-to-r from-amber-50 to-amber-100/50 py-2 px-3 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-amber-800/50 dark:from-amber-900/20 dark:to-amber-800/10">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="h-3 w-3 animate-pulse rounded-full bg-amber-500 shadow-lg shadow-amber-500/50"></div>
                                        <div class="absolute inset-0 h-3 w-3 animate-ping rounded-full bg-amber-400 opacity-75"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-amber-900 dark:text-amber-300">{{ __('Pending') }}</span>
                                </div>
                                <span class="rounded-lg bg-amber-200 px-2 py-0.5 text-xs font-bold text-amber-900 dark:bg-amber-800 dark:text-amber-100">{{ $taskPending }}</span>
                            </div>
                            <div class="group flex items-center justify-between border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100/50 py-2 px-3 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-blue-800/50 dark:from-blue-900/20 dark:to-blue-800/10">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="h-3 w-3 animate-pulse rounded-full bg-blue-500 shadow-lg shadow-blue-500/50"></div>
                                        <div class="absolute inset-0 h-3 w-3 animate-ping rounded-full bg-blue-400 opacity-75"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-blue-900 dark:text-blue-300">{{ __('Running') }}</span>
                                </div>
                                <span class="rounded-lg bg-blue-200 px-2 py-0.5 text-xs font-bold text-blue-900 dark:bg-blue-800 dark:text-blue-100">{{ $taskRunning }}</span>
                            </div>
                            <div class="group flex items-center justify-between border border-emerald-200 bg-gradient-to-r from-emerald-50 to-emerald-100/50 py-2 px-3 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-emerald-800/50 dark:from-emerald-900/20 dark:to-emerald-800/10">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="h-3 w-3 animate-pulse rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></div>
                                        <div class="absolute inset-0 h-3 w-3 animate-ping rounded-full bg-emerald-400 opacity-75"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-emerald-900 dark:text-emerald-300">{{ __('Completed') }}</span>
                                </div>
                                <span class="rounded-lg bg-emerald-200 px-2 py-0.5 text-xs font-bold text-emerald-900 dark:bg-emerald-800 dark:text-emerald-100">{{ $taskCompleted }}</span>
                            </div>
                            <div class="group flex items-center justify-between border border-red-200 bg-gradient-to-r from-red-50 to-red-100/50 py-2 px-3 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-red-800/50 dark:from-red-900/20 dark:to-red-800/10">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="h-3 w-3 animate-pulse rounded-full bg-red-500 shadow-lg shadow-red-500/50"></div>
                                        <div class="absolute inset-0 h-3 w-3 animate-ping rounded-full bg-red-400 opacity-75"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-red-900 dark:text-red-300">{{ __('Cancelled') }}</span>
                                </div>
                                <span class="rounded-lg bg-red-200 px-2 py-0.5 text-xs font-bold text-red-900 dark:bg-red-800 dark:text-red-100">{{ $taskCancelled }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Tasks Table -->
                    @if($upcomingTasks->count() > 0)
                        <div>
                            <h4 class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-300">{{ __('Upcoming Tasks') }}</h4>
                            <!-- Table View: Large screens only -->
                            <div class="hidden lg:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                    <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                        @foreach($upcomingTasks as $task)
                                            <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
                                                <td class="whitespace-normal px-4 py-3 w-1/2">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</span>
                                                        @if($task->description)
                                                            <span class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-4">{{ $task->description }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3">
                                                    <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }" size="sm" class="font-semibold">
                                                        {{ ucfirst($task->priority) }}
                                                    </flux:badge>
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3">
                                                    <flux:badge :color="match($task->status) { 'completed' => 'green', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }" size="sm" class="font-semibold">
                                                        {{ ucfirst($task->status) }}
                                                    </flux:badge>
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3">
                                                    @if($task->work_date)
                                                        <div class="flex flex-col gap-1">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                                <span class="text-sm text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</span>
                                                            </div>
                                                            @if($task->work_time)
                                                                <div class="flex items-center gap-2">
                                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3">
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
                            <div class="lg:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                                <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                    @foreach($upcomingTasks as $task)
                                        <div class="p-3 group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
                                            <!-- Title and Description -->
                                            <div class="mb-2">
                                                <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</h5>
                                                @if($task->description)
                                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-4">{{ $task->description }}</p>
                                                @endif
                                            </div>
                                            <!-- All other info in one row -->
                                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                                <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }" size="sm" class="font-semibold">
                                                    {{ ucfirst($task->priority) }}
                                                </flux:badge>
                                                <flux:badge :color="match($task->status) { 'completed' => 'green', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }" size="sm" class="font-semibold">
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
                        </div>
                    @endif
                </div>
            </div>

            <!-- Members Card -->
            @if($members->count() > 0)
                <div class="group relative overflow-hidden rounded-2xl border border-blue-200 bg-gradient-to-br from-white via-blue-50/30 to-cyan-50/30 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl dark:border-blue-900/50 dark:from-gray-900 dark:via-blue-900/20 dark:to-cyan-900/20">
                    <!-- Decorative Elements -->
                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-2xl"></div>

                    <div class="relative">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <div class="h-1 w-8 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500"></div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Members') }}</h3>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Team members overview') }}</p>
                            </div>
                            <div class="animate-pulse rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 p-4 shadow-lg shadow-blue-500/50">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Role Counts Section -->
                        <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                            <!-- Admin Count -->
                            <div class="group relative overflow-hidden rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-red-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-red-800/50 dark:from-red-900/20 dark:to-red-800/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-red-700 dark:text-red-400">{{ __('Admin') }}</p>
                                        <p class="mt-1 text-2xl font-bold text-red-900 dark:text-red-200">{{ $adminCount }}</p>
                                    </div>
                                    <div class="rounded-lg bg-red-200/50 p-2 dark:bg-red-900/30">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Manager Count -->
                            <div class="group relative overflow-hidden rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 to-blue-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-blue-800/50 dark:from-blue-900/20 dark:to-blue-800/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-blue-700 dark:text-blue-400">{{ __('Manager') }}</p>
                                        <p class="mt-1 text-2xl font-bold text-blue-900 dark:text-blue-200">{{ $managerCount }}</p>
                                    </div>
                                    <div class="rounded-lg bg-blue-200/50 p-2 dark:bg-blue-900/30">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Employee Count -->
                            <div class="group relative overflow-hidden rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-emerald-800/50 dark:from-emerald-900/20 dark:to-emerald-800/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-emerald-700 dark:text-emerald-400">{{ __('Employee') }}</p>
                                        <p class="mt-1 text-2xl font-bold text-emerald-900 dark:text-emerald-200">{{ $employeeCount }}</p>
                                    </div>
                                    <div class="rounded-lg bg-emerald-200/50 p-2 dark:bg-emerald-900/30">
                                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Client Count -->
                            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-gray-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-gray-800/50 dark:from-gray-900/20 dark:to-gray-800/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-400">{{ __('Client') }}</p>
                                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-200">{{ $clientCount }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-200/50 p-2 dark:bg-gray-900/30">
                                        <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table View: Large screens only -->
                        <div class="hidden lg:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                    @foreach($members as $member)
                                        <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-cyan-50/50 dark:hover:from-blue-900/10 dark:hover:to-cyan-900/10">
                                            <td class="whitespace-nowrap p-4 w-1/3">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative size-10 flex-shrink-0">
                                                        @if($member->avatar && $member->avatar_url)
                                                            <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="size-10 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                                                        @else
                                                            <div class="flex size-10 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800">
                                                                <span class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $member->initials() }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('Member since :date', ['date' => $member->created_at->format('M Y')]) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4">
                                                <div class="flex justify-center">
                                                    <flux:badge class="font-semibold w-20 text-center" :color="match($member->role) { 'admin' => 'red', 'manager' => 'blue', 'employee' => 'green', default => 'gray' }" size="sm">
                                                        {{ ucfirst($member->role) }}
                                                    </flux:badge>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap p-4">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-900 dark:text-white">{{ $member->email }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vertical Stacked View: Medium screens and below -->
                        <div class="lg:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                            <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @foreach($members as $member)
                                    <div class="p-3 group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-cyan-50/50 dark:hover:from-blue-900/10 dark:hover:to-cyan-900/10">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="relative size-10 flex-shrink-0">
                                                @if($member->avatar && $member->avatar_url)
                                                    <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="size-10 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                                                @else
                                                    <div class="flex size-10 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800">
                                                        <span class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $member->initials() }}</span>
                                                    </div>
                                                @endif
                                                <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('Member since :date', ['date' => $member->created_at->format('M Y')]) }}</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2 text-xs">
                                            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $member->email }}
                                            </span>
                                            <flux:badge :color="match($member->role) { 'admin' => 'red', 'manager' => 'blue', 'employee' => 'green', default => 'gray' }" size="sm" class="font-semibold">
                                                {{ ucfirst($member->role) }}
                                            </flux:badge>
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            function initializeCharts() {
                // Destroy existing charts if they exist
                if (window.taskChart && typeof window.taskChart.destroy === 'function') {
                    window.taskChart.destroy();
                }

                // Task Status Donut Chart
                const taskCtx = document.getElementById('taskChart');
                if (!taskCtx) return;

                window.taskChart = new Chart(taskCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Running', 'Completed', 'Cancelled'],
                        datasets: [{
                            data: [{{ $taskPending }}, {{ $taskRunning }}, {{ $taskCompleted }}, {{ $taskCancelled }}],
                            backgroundColor: [
                                'rgba(245, 158, 11, 0.8)',  // Amber
                                'rgba(59, 130, 246, 0.8)',  // Blue
                                'rgba(16, 185, 129, 0.8)',  // Emerald
                                'rgba(239, 68, 68, 0.8)',   // Red
                            ],
                            borderColor: [
                                'rgb(245, 158, 11)',
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(239, 68, 68)',
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

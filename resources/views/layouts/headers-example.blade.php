{{-- DESIGN 1: Gradient with Floating Elements --}}
<div
    class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-8 shadow-xl transition-all duration-300 hover:shadow-2xl">
    <!-- Floating Decorative Elements -->
    <div class="absolute -right-12 -top-12 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
    <div class="absolute -bottom-8 -left-8 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
    <div class="absolute right-20 top-10 h-24 w-24 rounded-full bg-white/5 blur-xl"></div>

    <div class="relative flex items-center justify-between">
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                    </h1>
                    <p class="mt-1 text-indigo-100">{{ 'Today is ' . now()->format('l, F jS, Y') }}</p>
                </div>
            </div>
        </div>
        <div class="hidden rounded-full bg-white/20 p-6 backdrop-blur-sm md:block">
            <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
    </div>
</div>

{{-- DESIGN 2: Minimal with Border Accent --}}
<div
    class="group relative overflow-hidden rounded-2xl border-2 border-indigo-200 bg-white p-8 shadow-lg transition-all duration-300 hover:border-indigo-400 hover:shadow-xl dark:border-indigo-800 dark:bg-zinc-900">
    <!-- Accent Line -->
    <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500">
    </div>

    <div class="flex items-center justify-between">
        <div class="ml-6 flex-1">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                    <span class="text-3xl font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                    </h1>
                    <p class="mt-2 flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ now()->format('l, F jS, Y') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="hidden flex-col items-end gap-2 md:flex">
            <div
                class="rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-3 text-center shadow-md">
                <p class="text-xs font-medium text-indigo-100">Current Time</p>
                <p class="text-xl font-bold text-white">{{ now()->format('h:i A') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- DESIGN 3: Card Grid Layout --}}
<div class="grid gap-4 md:grid-cols-2">
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

{{-- DESIGN 4: Glassmorphism Style --}}
<div
    class="group relative overflow-hidden rounded-3xl border border-white/20 bg-gradient-to-br from-indigo-500/90 via-purple-500/90 to-pink-500/90 p-8 shadow-2xl backdrop-blur-xl">
    <!-- Animated Background Elements -->
    <div class="absolute -right-20 -top-20 h-64 w-64 animate-pulse rounded-full bg-white/10 blur-3xl"></div>
    <div class="absolute -bottom-10 -left-10 h-48 w-48 animate-pulse rounded-full bg-white/10 blur-2xl"
         style="animation-delay: 1s;"></div>

    <div class="relative">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-4">
                <!-- Avatar -->
                <div class="group relative">
                    <div
                        class="h-20 w-20 overflow-hidden rounded-2xl border-4 border-white/30 bg-white/20 backdrop-blur-sm">
                        <div class="flex h-full w-full items-center justify-center">
                                    <span
                                        class="text-3xl font-bold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-1 -right-1 h-6 w-6 rounded-full border-4 border-white bg-green-500">
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-3xl font-bold text-white">
                            {{ __('Welcome back!') }}
                        </h1>
                        <span class="animate-bounce text-2xl">👋</span>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-white/90">{{ auth()->user()->name }}</p>
                    <p class="mt-1 text-sm text-white/70">{{ now()->format('l, F jS, Y • h:i A') }}</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="flex gap-4">
                <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-4 backdrop-blur-sm">
                    <p class="text-xs font-medium text-white/70">Today's Tasks</p>
                    <p class="mt-1 text-2xl font-bold text-white">
                        {{ \App\Models\Task::whereDate('created_at', today())->count() }}</p>
                </div>
                <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-4 backdrop-blur-sm">
                    <p class="text-xs font-medium text-white/70">Active</p>
                    <p class="mt-1 text-2xl font-bold text-white">
                        {{ \App\Models\Task::where('status', 'running')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DESIGN 5: Split Color Block --}}
<div class="grid gap-0 overflow-hidden rounded-2xl shadow-2xl md:grid-cols-2">
    <!-- Left Side - Gradient -->
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-600 p-8">
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>

        <div class="relative">
            <div
                class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-2 backdrop-blur-sm">
                <div class="h-2 w-2 animate-pulse rounded-full bg-green-400"></div>
                <span class="text-xs font-semibold text-white">Online</span>
            </div>

            <h1 class="text-4xl font-bold leading-tight text-white">
                {{ __('Hello,') }}<br>
                {{ auth()->user()->name }}!
            </h1>

            <p class="mt-4 text-violet-100">
                {{ __("Ready to be productive today? Let's make it count!") }}
            </p>

            <div class="mt-6 flex gap-3">
                <div class="flex items-center gap-2 rounded-lg bg-white/10 px-3 py-2 backdrop-blur-sm">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium text-white">{{ now()->format('h:i A') }}</span>
                </div>
                <div class="flex items-center gap-2 rounded-lg bg-white/10 px-3 py-2 backdrop-blur-sm">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium text-white">{{ now()->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Light -->
    <div class="bg-white p-8 dark:bg-zinc-900">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Quick Overview') }}</h3>

        <div class="space-y-4">
            <div
                class="flex items-center justify-between rounded-xl border-2 border-gray-100 p-4 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Total Tasks') }}</span>
                </div>
                <span
                    class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Task::count() }}</span>
            </div>

            <div
                class="flex items-center justify-between rounded-xl border-2 border-gray-100 p-4 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Completed') }}</span>
                </div>
                <span
                    class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Task::where('status', 'completed')->count() }}</span>
            </div>

            <div
                class="flex items-center justify-between rounded-xl border-2 border-gray-100 p-4 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Pending') }}</span>
                </div>
                <span
                    class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Task::where('status', 'pending')->count() }}</span>
            </div>
        </div>
    </div>
</div>

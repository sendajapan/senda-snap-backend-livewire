<x-layouts.public>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Main Header -->
        <x-page-header :title="__('Android App Manual')" :description="__('Senda Snap v1.0 - Complete guide for using the Android mobile application. Learn all features and get the most out of the app.')" variant="violet">
            <x-slot:icon>
                <svg class="h-7 w-7 flex-shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <a href="{{ asset('senda_snap.release_1.0_25_11_25.apk') }}" 
                   download="senda_snap.release_1.0_25_11_25.apk"
                   class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-md transition-all hover:bg-gray-50 hover:shadow-lg dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>{{ __('Download APK') }}</span>
                </a>
            </x-slot:actions>
        </x-page-header>

        <!-- Introduction Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Welcome to Senda Snap') }}</h2>
                </div>

                <div class="space-y-6">
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                        {{ __('Senda Snap is a comprehensive mobile application designed for vehicle management, task scheduling, and team collaboration. This manual will guide you through all features and help you get the most out of the app.') }}
                    </p>

                    <!-- Features and Image Side by Side -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                        <!-- Features List -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}
                            </h3>
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                <li class="font-semibold">{{ __('Vehicle Search & Photo Upload') }}</li>
                                <li class="font-semibold">{{ __('Task & Schedule Management') }}</li>
                                <li class="font-semibold">{{ __('Team Communication (Chat)') }}</li>
                                <li class="font-semibold">{{ __('Profile & Settings') }}</li>
                                <li class="font-semibold">{{ __('Search History') }}</li>
                                    </ul>
                        </div>

                        <!-- Feature Image (No Phone Mockup) -->
                        <div class="flex justify-center lg:justify-end">
                            <div class="w-full max-w-lg">
                                <div class="relative overflow-hidden rounded-3xl shadow-lg">
                                    <img src="{{ asset('assets/app-manual/feature.png') }}" 
                                         alt="{{ __('App Features') }}" 
                                         class="w-full h-auto cursor-pointer hover:opacity-90 transition-opacity manual-image"
                                        style="mask-image: radial-gradient(ellipse 80% 80% at center, black 60%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 80% 80% at center, black 60%, transparent 100%);"
                                         data-zoom-src="{{ asset('assets/app-manual/feature.png') }}"
                                         data-zoom-alt="{{ __('App Features') }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="p-12 text-center" style="display: none;">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                                            {{ __('App Features Screenshot') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Features Guide Section -->

        <!-- Vehicle Search & Management -->
                <x-table-card variant="emerald">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                            </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ __('Vehicle Search & Photo Upload') }}
                    </h2>
                        </div>

                        <div class="space-y-8">
                    <!-- First Div: Feature Image + Keypoints -->
                    <div class="flex flex-col items-center gap-6 lg:flex-row lg:justify-center lg:items-center">
                        <!-- Feature Image -->
                        <div class="flex justify-center">
                            <x-phone-mockup 
                                image="assets/app-manual/vehicle-list.jpg"
                                :alt="__('Vehicle Search & Management')"
                                zoomable="true" />
                        </div>
                        <!-- Keypoints -->
                        <div class="mt-8 space-y-4 w-full max-w-md">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}
                            </h3>
                            <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                <li class="font-semibold">{{ __('Search vehicles by vehicle id or chassis number') }}
                                </li>
                                <li class="font-semibold">{{ __('View comprehensive vehicle details') }}</li>
                                <li class="font-semibold">{{ __('Add vehicle photos') }}</li>
                                <li class="font-semibold">{{ __('Access recent vehicles') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Second Div: 3 Images in Grid -->
                                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('How It Works') }}</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/search-vehicle.jpg"
                                    :alt="__('Searching for Vehicles')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Click on search button then from dropdown menu select an option to search by vehicle id or chassis number') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Enter the vehicle id or chassis number in second input field, please make sure to enter the correct vehicle id or chassis number') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Click on search button to search for the vehicle') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/vehicle-detail.jpg"
                                    :alt="__('Vehicle Details')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('On Detail page, you can see basic information, purchase information, shipping information and existing photos of the vehicle') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('User is not allowed to edit the vehicle information from the android app, but user can add photos to the vehicle') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {!! __('To edit the vehicle information, user needs to go to <a class="text-blue-500 hover:underline" href=":url" target="_blank">AVIS</a> and edit the vehicle information', ['url' => 'https://senda.us/autocraft/avisnew/']) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/vehicle-image-upload.jpg"
                                    :alt="__('Add Vehicle Photos')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('At the bottom of the page, you will see a plus icon button to add more photos to the vehicle') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('After clicking the plus icon button, user will be redirected to the camera or gallery to select a photo to upload, User can add multiple photos to the vehicle') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-emerald-100 text-sm font-bold text-emerald-600 dark:border-emerald-400 dark:bg-emerald-900/40 dark:text-emerald-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Clicking in upload button will upload the photo to the vehicle') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Task & Schedule Management -->
        <x-table-card variant="violet">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-violet-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Task & Schedule Management') }}
                    </h2>
                </div>

                <div class="space-y-8">
                    <!-- First Div: Feature Image + Keypoints -->
                    <div class="flex flex-col items-center gap-6 lg:flex-row lg:justify-center lg:items-center">
                        <!-- Feature Image -->
                        <div class="flex justify-center">
                            <x-phone-mockup 
                                image="assets/app-manual/task-list.jpg"
                                :alt="__('Task Dashboard')"
                                zoomable="true" />
                        </div>
                        <!-- Keypoints -->
                        <div class="mt-8 space-y-4 w-full max-w-md">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}
                            </h3>
                            <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                <li class="font-semibold">
                                    {{ __('Create new schedules with title, description, date, time, and assign team members') }}
                                </li>
                                <li class="font-semibold">
                                    {{ __('View all schedules organized by date, filter by status, priority, or date range') }}
                                </li>
                                <li class="font-semibold">
                                    {{ __('Update task status, edit task details, and manage task assignments efficiently') }}
                                </li>
                                <li class="font-semibold">
                                    {{ __('Receive push notifications for task assignments, reminders, and updates') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Second Div: 3 Images in Grid -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('How It Works') }}</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/task-create.jpg"
                                    :alt="__('Create Schedule')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Navigate to the Task Dashboard and tap the create button to start a new schedule') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Fill in the schedule details including title, description, date, time, and assign team members') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Save the schedule to create the task and automatically generate a group chat for assigned members') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/task-calender.jpg"
                                    :alt="__('Filter Task List')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Use the calendar view or date filter to view tasks for specific dates') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Filter tasks by status (pending, running, completed, cancelled) from the filter buttons') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('View filtered task list organized by date and status for easy management') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/task-status-update.jpg"
                                    :alt="__('Update Task Status')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Long press on a task from the list to show the options menu') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Select the status update option to open the alert dialog with available status options') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-purple-500 bg-purple-100 text-sm font-bold text-purple-600 dark:border-purple-400 dark:bg-purple-900/40 dark:text-purple-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Delete the task by clicking the delete option from the options menu') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Team Communication (Chat) -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Team Communication (Chat)') }}
                    </h2>
                </div>
        
                <div class="space-y-8">
                    <!-- First Div: Feature Image + Keypoints -->
                    <div class="flex flex-col items-center gap-6 lg:flex-row lg:justify-center lg:items-center">
                        <!-- Feature Image -->
                        <div class="flex justify-center">
                            <x-phone-mockup 
                                image="assets/app-manual/chatting.jpg"
                                :alt="__('Team Communication')"
                                zoomable="true" />
                        </div>
                        <!-- Keypoints -->
                        <div class="mt-8 space-y-4 w-full max-w-md">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}
                            </h3>
                            <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                <li class="font-semibold">
                                    {{ __('Messages are delivered instantly to all participants in group or individual chats') }}
                                </li>
                                <li class="font-semibold">
                                    {{ __('Automatically created group chats for schedules, including all assigned team members') }}
                                </li>
                                <li class="font-semibold">
                                    {{ __('All chat messages are saved and accessible for future reference with unread indicators') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Second Div: 3 Images in Grid -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('How It Works') }}</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/chat-icon.jpg"
                                    :alt="__('Chat List')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Click on the chat icon from top right corner of Task Details page') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Group chats are automatically created for schedules with all assigned team members') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Unread message indicators show the number of unread messages in each chat') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/start-chatting.jpg"
                                    :alt="__('Chat Messages')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Send text messages instantly to team members in group or individual chats') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">2</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Messages are delivered in real-time to all participants') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">3</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('View message timestamps and read receipts for better communication tracking') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3 flex flex-col items-center">
                                <x-phone-mockup 
                                    image="assets/app-manual/chatting.jpg"
                                    :alt="__('Share Media & Files')"
                                    zoomable="true" />
                                <div class="w-full space-y-2">
                                    <div class="flex gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-blue-500 bg-blue-100 text-sm font-bold text-blue-600 dark:border-blue-400 dark:bg-blue-900/40 dark:text-blue-400">1</div>
                                        <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('Tap the attachment icon to share images is not functionality in this version') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Troubleshooting Section -->
        <x-table-card variant="red">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Troubleshooting') }}</h2>
                    </div>

                    <div class="space-y-4">
                    <div
                        class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                        <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">{{ __('Cannot Login') }}
                        </h3>
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Verify your email and password are correct') }}</li>
                            <li>{{ __('Check your internet connection') }}</li>
                            <li>{{ __('Try resetting your password if forgotten') }}</li>
                            <li>{{ __('Ensure the app is updated to the latest version') }}</li>
                                    </ul>
                            </div>
                    <div
                        class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                        <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">
                            {{ __('Vehicle Search Not Working') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Check your internet connection') }}</li>
                            <li>{{ __('Verify you entered the correct chassis number or identifier') }}</li>
                            <li>{{ __('Try refreshing the search') }}</li>
                            <li>{{ __('Clear app cache if the issue persists') }}</li>
                        </ul>
                    </div>
                    <div
                        class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                        <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">
                            {{ __('Images Not Uploading') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Check your internet connection') }}</li>
                            <li>{{ __('Ensure image size is under 5MB') }}</li>
                            <li>{{ __('Grant storage permission if prompted') }}</li>
                            <li>{{ __('Try compressing the image before uploading') }}</li>
                        </ul>
                    </div>
                    <div
                        class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                        <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">
                            {{ __('Chat Messages Not Sending') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Check your internet connection') }}</li>
                            <li>{{ __('Verify you have permission to send messages in the chat') }}</li>
                            <li>{{ __('Try closing and reopening the chat') }}</li>
                            <li>{{ __('Restart the app if the issue persists') }}</li>
                        </ul>
                    </div>
                    <div
                        class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                        <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">
                            {{ __('App Crashes or Freezes') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Close and restart the app') }}</li>
                            <li>{{ __('Clear app cache from device settings') }}</li>
                            <li>{{ __('Update to the latest version of the app') }}</li>
                            <li>{{ __('Restart your device if the problem continues') }}</li>
                            <li>{{ __('Contact support if the issue persists') }}</li>
                        </ul>
                    </div>
                </div>
            </x-table-card>

        <!-- Support & Contact Section -->
        <div class="mt-4">
            <x-table-card variant="violet">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Support & Contact') }}</h2>
                    </div>

                <div class="space-y-4">
                            <div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Getting Help') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('sulaiman@sendajapan.com') }}</li>
                            <li>{{ __('+819019735910') }}</li>
                            <li>{{ __('sendajapan.com') }}</li>
                        </ul>
                                            </div>
                    <div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('Reporting Issues') }}
                        </h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Document the issue with screenshots if possible') }}</li>
                            <li>{{ __('Note the steps that led to the problem') }}</li>
                            <li>{{ __('Include your device model and Android version') }}</li>
                                                    </ul>
                                            </div>
                    </div>
                </div>
            </x-table-card>
        </div>
    </div>

    <!-- Smartphone Mockup Styles -->
    <style>
        /* Smartphone Mockup Styles */
        .phone-mockup {
            display: inline-block;
            padding: 12px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
            border-radius: 40px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.2),
                0 0 0 8px rgba(255, 255, 255, 0.1),
                inset 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .dark .phone-mockup {
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .dark .phone-mockup {
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.5),
                0 0 0 8px rgba(255, 255, 255, 0.05),
                inset 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .phone-frame {
            width: 280px;
            max-width: 100%;
            background: transparent;
            border-radius: 32px;
            padding: 0;
            box-shadow: none;
            position: relative;
        }

        .phone-frame::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            z-index: 10;
        }

        .dark .phone-frame::before {
            background: rgba(255, 255, 255, 0.2);
        }

        .phone-screen {
            width: 100%;
            background: #000;
            border-radius: 32px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-image {
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .phone-frame {
                width: 240px;
            }
        }

        @media (min-width: 768px) {
            .phone-frame {
                width: 300px;
            }
        }
    </style>

    <!-- Image Zoom Modal -->
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm"
        role="dialog" aria-modal="true" aria-labelledby="zoomModalTitle">
        <div class="relative max-h-[90vh] max-w-[90vw] p-4">
            <button id="closeZoomModal"
                class="absolute -top-2 -right-2 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-900 shadow-lg transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                aria-label="{{ __('Close') }}">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="zoomedImage" src="" alt="" class="max-h-[90vh] max-w-full rounded-lg object-contain shadow-2xl">
            <p id="zoomImageAlt" class="mt-4 text-center text-sm font-medium text-white"></p>
        </div>
    </div>

    @push('scripts')
        <script>
            // Image Zoom Functionality
            (function () {
                const modal = document.getElementById('imageZoomModal');
                const zoomedImage = document.getElementById('zoomedImage');
                const zoomImageAlt = document.getElementById('zoomImageAlt');
                const closeButton = document.getElementById('closeZoomModal');
                const manualImages = document.querySelectorAll('.manual-image');

                function openZoomModal(src, alt) {
                    zoomedImage.src = src;
                    zoomedImage.alt = alt;
                    zoomImageAlt.textContent = alt;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                }

                function closeZoomModal() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';
                    zoomedImage.src = '';
                }

                // Add click handlers to all manual images
                manualImages.forEach(img => {
                    img.addEventListener('click', function () {
                        const zoomSrc = this.getAttribute('data-zoom-src') || this.src;
                        const zoomAlt = this.getAttribute('data-zoom-alt') || this.alt;
                        openZoomModal(zoomSrc, zoomAlt);
                    });
                });

                // Close modal handlers
                closeButton.addEventListener('click', closeZoomModal);
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeZoomModal();
                    }
                });

                // Close on ESC key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeZoomModal();
                    }
                });
            })();

            // Particle Canvas Animation
            (function () {
                const canvas = document.getElementById('particle-canvas');
                if (!canvas) return;
                
                // Show canvas for this page
                canvas.style.display = 'block';
                
                const ctx = canvas.getContext('2d');
                let particles = [];
                let animationId;
                
                // Set canvas size
                function resizeCanvas() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);
                
                // Color palette matching design system
                const colorPalettes = {
                    light: {
                        violet: '124, 58, 237',
                        blue: '59, 130, 246',
                        emerald: '16, 185, 129',
                        amber: '245, 158, 11',
                        purple: '168, 85, 247',
                        cyan: '6, 182, 212',
                        teal: '20, 184, 166',
                        orange: '249, 115, 22'
                    },
                    dark: {
                        violet: '139, 92, 246',
                        blue: '96, 165, 250',
                        emerald: '52, 211, 153',
                        amber: '251, 191, 36',
                        purple: '192, 132, 252',
                        cyan: '34, 211, 238',
                        teal: '45, 212, 191',
                        orange: '251, 146, 60'
                    }
                };
                
                // Particle class
                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 0.5;
                        this.speedY = (Math.random() - 0.5) * 0.5;
                        this.opacity = Math.random() * 0.5 + 0.2;
                        
                        // Randomly assign a color from the palette
                        const isDark = document.documentElement.classList.contains('dark');
                        const palette = isDark ? colorPalettes.dark : colorPalettes.light;
                        const colors = Object.values(palette);
                        this.color = colors[Math.floor(Math.random() * colors.length)];
                    }
                    
                    update() {
                        this.x += this.speedX;
                        this.y += this.speedY;
                        
                        if (this.x > canvas.width) this.x = 0;
                        if (this.x < 0) this.x = canvas.width;
                        if (this.y > canvas.height) this.y = 0;
                        if (this.y < 0) this.y = canvas.height;
                    }
                    
                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(${this.color}, ${this.opacity})`;
                        ctx.fill();
                    }
                }
                
                // Create particles
                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
                    for (let i = 0; i < particleCount; i++) {
                        particles.push(new Particle());
                    }
                }
                
                // Draw connections
                function drawConnections() {
                    for (let i = 0; i < particles.length; i++) {
                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);
                
                            if (distance < 120) {
                                ctx.beginPath();
                                // Use gradient between two particle colors - darker opacity
                                const gradient = ctx.createLinearGradient(
                                    particles[i].x, particles[i].y,
                                    particles[j].x, particles[j].y
                                );
                                gradient.addColorStop(0, `rgba(${particles[i].color}, ${0.3 * (1 - distance / 120)})`);
                                gradient.addColorStop(1, `rgba(${particles[j].color}, ${0.3 * (1 - distance / 120)})`);
                                ctx.strokeStyle = gradient;
                                ctx.lineWidth = 0.5;
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(particles[j].x, particles[j].y);
                                ctx.stroke();
                            }
                        }
                    }
                }
                
                // Animation loop
                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    
                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });
                    
                    drawConnections();
                    
                    animationId = requestAnimationFrame(animate);
                }
                
                // Initialize and start
                initParticles();
                animate();
                
                // Cleanup on page unload
                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            })();
        </script>
    @endpush
</x-layouts.public>
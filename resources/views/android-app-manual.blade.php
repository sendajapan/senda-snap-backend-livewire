@php
    $appInfo = $manualData['app_name'] ?? 'Senda Snap';
    $version = $manualData['version'] ?? '1.0';
    $manual = $manualData['manual'] ?? [];
@endphp

<x-layouts.public>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Main Header -->
        <x-page-header 
            :title="__('Android App Manual')" 
            :description="__(':appName v:version - Complete guide for using the Android mobile application. Learn all features and get the most out of the app.', ['appName' => $appInfo, 'version' => $version])" 
            variant="violet">
            <x-slot:icon>
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <a href="{{ asset('senda_snap.release_1.0_25_11_25.apk') }}" 
                   download="senda_snap.release_1.0_25_11_25.apk"
                   class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-md transition-all hover:bg-gray-50 hover:shadow-lg dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>{{ __('Download APK') }}</span>
                </a>
            </x-slot:actions>
        </x-page-header>

        <!-- Introduction Section -->
        <x-table-card variant="violet">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['introduction']['title'] ?? 'Welcome to Senda Snap' }}</h2>
                </div>

                <div class="space-y-6">
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                        {{ $manual['introduction']['description'] ?? '' }}
                    </p>

                    <!-- Features and Image Side by Side -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                        <!-- Features List -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}</h3>
                            
                            @if(isset($manual['features']['sections']))
                                <div class="space-y-3">
                                    @foreach($manual['features']['sections'] as $feature)
                                        <div class="flex items-start gap-3 rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                            @if(isset($feature['icon']))
                                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-violet-500 text-2xl">
                                                    {{ $feature['icon'] }}
                                                </div>
                                            @else
                                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-violet-500">
                                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $feature['feature_name'] ?? '' }}</h4>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(isset($manual['introduction']['target_audience']))
                                <div class="mt-6">
                                    <h3 class="mb-3 text-base font-semibold text-gray-900 dark:text-white">{{ __('Target Audience') }}</h3>
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($manual['introduction']['target_audience'] as $audience)
                                            <li>{{ $audience }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Feature Image (No Phone Mockup) -->
                        <div class="flex justify-center lg:justify-end">
                            <div class="w-full max-w-lg">
                                <div class="overflow-hidden rounded-xl border-2 border-gray-200 bg-gray-50 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    <img src="{{ asset('assets/app-manual/feature.png') }}" 
                                         alt="{{ __('App Features') }}" 
                                         class="w-full h-auto cursor-pointer hover:opacity-90 transition-opacity manual-image"
                                         data-zoom-src="{{ asset('assets/app-manual/feature.png') }}"
                                         data-zoom-alt="{{ __('App Features') }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="p-12 text-center" style="display: none;">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
        @if(isset($manual['features']['sections']))
            @php
                $sectionIndex = 0;
            @endphp
            @foreach($manual['features']['sections'] as $feature)
                <x-table-card variant="emerald">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                @if(isset($feature['icon']))
                                    <span class="text-2xl">{{ $feature['icon'] }}</span>
                                @else
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                @endif
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $feature['feature_name'] ?? '' }}</h2>
                        </div>

                        <div class="space-y-8">
                            @if(isset($feature['sections']))
                                @foreach($feature['sections'] as $section)
                                    @php
                                        $sectionTitle = strtolower($section['section_title'] ?? '');
                                        $imageMap = [
                                            'searching for vehicles' => 'search-vehicle.jpg',
                                            'vehicle details' => 'vehicle-list.jpg',
                                            'recent vehicles' => 'vehicle-list.jpg',
                                            'creating a schedule' => 'create-task.jpg',
                                            'viewing schedules' => 'task-list.jpg',
                                            'managing tasks' => 'task-list-long.jpg',
                                            'starting a chat' => 'chatting.jpg',
                                            'sending messages' => 'chatting.jpg',
                                            'chat features' => 'chatting.jpg',
                                            'managing attachments' => 'chatting.jpg',
                                            'viewing your profile' => 'dashboard-menu.jpg',
                                            'account management' => 'dashboard-menu.jpg',
                                            'viewing history' => 'dashboard-menu.jpg',
                                        ];
                                        $imageFile = null;
                                        foreach($imageMap as $key => $img) {
                                            if(str_contains($sectionTitle, $key)) {
                                                $imageFile = $img;
                                                break;
                                            }
                                        }
                                        $screenshotOnLeft = ($sectionIndex % 2 === 0);
                                        $sectionIndex++;
                                    @endphp

                                    <div class="space-y-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $section['section_title'] ?? '' }}</h3>
                                        
                                        <!-- Instructions and Screenshot Side by Side -->
                                        @if($imageFile)
                                            <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                                                @if($screenshotOnLeft)
                                                    <!-- Screenshot on Left -->
                                                    <div class="flex justify-center lg:justify-start order-2 lg:order-1">
                                                        <div class="phone-mockup">
                                                            <div class="phone-frame">
                                                                <div class="phone-screen">
                                                                    <img src="{{ asset('assets/app-manual/' . $imageFile) }}" 
                                                                         alt="{{ $section['section_title'] ?? '' }}" 
                                                                         class="phone-image cursor-pointer hover:opacity-90 transition-opacity manual-image"
                                                                         data-zoom-src="{{ asset('assets/app-manual/' . $imageFile) }}"
                                                                         data-zoom-alt="{{ $section['section_title'] ?? '' }}"
                                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div class="p-12 text-center" style="display: none;">
                                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                        </svg>
                                                                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                                                                            {{ $section['section_title'] ?? '' }} {{ __('Screenshot') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Instructions on Right -->
                                                    <div class="space-y-4 order-1 lg:order-2">
                                                @else
                                                    <!-- Instructions on Left -->
                                                    <div class="space-y-4">
                                                @endif
                                                
                                                @if(isset($section['description']) && !isset($section['steps']) && !isset($section['features']) && !isset($section['options']))
                                                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $section['description'] }}</p>
                                                @endif

                                                @if(isset($section['steps']))
                                                    <div class="space-y-3">
                                                        @foreach($section['steps'] as $step)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <div class="mb-2 flex items-center gap-3">
                                                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white font-bold">
                                                                        {{ $step['step'] ?? '' }}
                                                                    </div>
                                                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $step['title'] ?? '' }}</h4>
                                                                </div>
                                                                <p class="ml-11 text-sm text-gray-700 dark:text-gray-300">{{ $step['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(isset($section['features']))
                                                    <div class="grid gap-3 md:grid-cols-1">
                                                        @foreach($section['features'] as $featureItem)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $featureItem['feature'] ?? '' }}</h4>
                                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $featureItem['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(isset($section['options']))
                                                    <div class="space-y-3">
                                                        @foreach($section['options'] as $option)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $option['option'] ?? '' }}</h4>
                                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $option['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                
                                                </div>
                                                
                                                @if(!$screenshotOnLeft)
                                                    <!-- Screenshot on Right -->
                                                    <div class="flex justify-center lg:justify-end order-2">
                                                        <div class="phone-mockup">
                                                            <div class="phone-frame">
                                                                <div class="phone-screen">
                                                                    <img src="{{ asset('assets/app-manual/' . $imageFile) }}" 
                                                                         alt="{{ $section['section_title'] ?? '' }}" 
                                                                         class="phone-image cursor-pointer hover:opacity-90 transition-opacity manual-image"
                                                                         data-zoom-src="{{ asset('assets/app-manual/' . $imageFile) }}"
                                                                         data-zoom-alt="{{ $section['section_title'] ?? '' }}"
                                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div class="p-12 text-center" style="display: none;">
                                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                        </svg>
                                                                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                                                                            {{ $section['section_title'] ?? '' }} {{ __('Screenshot') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- No screenshot, just content -->
                                            <div class="space-y-4">
                                                @if(isset($section['description']) && !isset($section['steps']) && !isset($section['features']) && !isset($section['options']))
                                                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $section['description'] }}</p>
                                                @endif

                                                @if(isset($section['steps']))
                                                    <div class="space-y-3">
                                                        @foreach($section['steps'] as $step)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <div class="mb-2 flex items-center gap-3">
                                                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white font-bold">
                                                                        {{ $step['step'] ?? '' }}
                                                                    </div>
                                                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $step['title'] ?? '' }}</h4>
                                                                </div>
                                                                <p class="ml-11 text-sm text-gray-700 dark:text-gray-300">{{ $step['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(isset($section['features']))
                                                    <div class="grid gap-4 md:grid-cols-2">
                                                        @foreach($section['features'] as $featureItem)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $featureItem['feature'] ?? '' }}</h4>
                                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $featureItem['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(isset($section['options']))
                                                    <div class="space-y-3">
                                                        @foreach($section['options'] as $option)
                                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                                <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $option['option'] ?? '' }}</h4>
                                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $option['description'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </x-table-card>
            @endforeach
        @endif

        <!-- Tips & Tricks Section -->
        @if(isset($manual['tips_and_tricks']['tips']))
            <x-table-card variant="amber">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['tips_and_tricks']['title'] ?? 'Tips & Tricks' }}</h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach($manual['tips_and_tricks']['tips'] as $tip)
                            <div class="rounded-xl border border-amber-200 bg-amber-50/30 p-4 dark:border-amber-900/50 dark:bg-amber-900/20">
                                <h3 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $tip['tip'] ?? '' }}</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $tip['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-table-card>
        @endif

        <!-- Troubleshooting Section -->
        @if(isset($manual['troubleshooting']['common_issues']))
            <x-table-card variant="red">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['troubleshooting']['title'] ?? 'Troubleshooting' }}</h2>
                    </div>

                    <div class="space-y-4">
                        @foreach($manual['troubleshooting']['common_issues'] as $issue)
                            <div class="rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/20">
                                <h3 class="mb-3 text-base font-semibold text-red-900 dark:text-red-400">{{ $issue['issue'] ?? '' }}</h3>
                                @if(isset($issue['solutions']))
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($issue['solutions'] as $solution)
                                            <li>{{ $solution }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-table-card>
        @endif

        <!-- FAQ Section -->
        @if(isset($manual['faq']['questions']))
            <x-table-card variant="blue">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['faq']['title'] ?? 'Frequently Asked Questions' }}</h2>
                    </div>

                    <div class="space-y-4">
                        @foreach($manual['faq']['questions'] as $faq)
                            <div class="rounded-xl border border-blue-200 bg-blue-50/30 p-4 dark:border-blue-900/50 dark:bg-blue-900/20">
                                <h3 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $faq['question'] ?? '' }}</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $faq['answer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-table-card>
        @endif

        <!-- Support & Contact Section -->
        @if(isset($manual['support']['sections']))
            <x-table-card variant="violet">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['support']['title'] ?? 'Support & Contact' }}</h2>
                    </div>

                    <div class="space-y-4">
                        @foreach($manual['support']['sections'] as $section)
                            <div>
                                <h3 class="mb-3 text-lg font-semibold text-gray-900 dark:text-white">{{ $section['section_title'] ?? '' }}</h3>
                                @if(isset($section['content']))
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($section['content'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-table-card>
        @endif

        <!-- Appendix Section -->
        @if(isset($manual['appendix']['sections']))
            <x-table-card variant="violet">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $manual['appendix']['title'] ?? 'Appendix' }}</h2>
                    </div>

                    <div class="space-y-6">
                        @foreach($manual['appendix']['sections'] as $section)
                            <div>
                                <h3 class="mb-3 text-lg font-semibold text-gray-900 dark:text-white">{{ $section['section_title'] ?? '' }}</h3>
                                
                                @if(isset($section['content']) && is_string($section['content']))
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['content'] }}</p>
                                @endif

                                @if(isset($section['terms']))
                                    <div class="space-y-3">
                                        @foreach($section['terms'] as $term)
                                            <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                                <h4 class="mb-1 text-base font-semibold text-gray-900 dark:text-white">{{ $term['term'] ?? '' }}</h4>
                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $term['definition'] ?? '' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(isset($section['versions']))
                                    <div class="space-y-4">
                                        @foreach($section['versions'] as $version)
                                            <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                                <div class="mb-3 flex items-center gap-3">
                                                    <span class="rounded-lg bg-violet-500 px-3 py-1 text-sm font-bold text-white">{{ $version['version'] ?? '' }}</span>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $version['date'] ?? '' }}</span>
                                                </div>
                                                @if(isset($version['features']))
                                                    <ul class="list-disc space-y-1 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                                        @foreach($version['features'] as $feature)
                                                            <li>{{ $feature }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-table-card>
        @endif
    </div>

    <!-- Smartphone Mockup Styles -->
    <style>
        /* Smartphone Mockup Styles */
        .phone-mockup {
            display: inline-block;
            padding: 12px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            border-radius: 40px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.2),
                0 0 0 8px rgba(255, 255, 255, 0.1),
                inset 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
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
            background: #000;
            border-radius: 32px;
            padding: 8px;
            box-shadow: 
                inset 0 0 0 2px rgba(255, 255, 255, 0.1),
                inset 0 0 20px rgba(0, 0, 0, 0.5);
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
            background: #1a1a1a;
            border-radius: 3px;
            z-index: 10;
        }

        .phone-screen {
            width: 100%;
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            aspect-ratio: 9 / 19.5;
            position: relative;
        }

        .phone-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="zoomModalTitle">
        <div class="relative max-h-[90vh] max-w-[90vw] p-4">
            <button id="closeZoomModal" class="absolute -top-2 -right-2 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-900 shadow-lg transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700" aria-label="{{ __('Close') }}">
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


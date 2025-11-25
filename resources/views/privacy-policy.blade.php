@php
    $appInfo = $policyData['app_info'] ?? [];
    $privacyPolicy = $policyData['privacy_policy'] ?? [];
    $termsOfService = $policyData['terms_of_service'] ?? [];
@endphp

<x-layouts.public>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Main Header -->
        <x-page-header 
            :title="__('Privacy Policy & Terms of Service')" 
            :description="__('SendaSnap Android App - Privacy Policy and Terms of Service. Last updated: :date', ['date' => $appInfo['last_updated'] ?? '2024-12-19'])" 
            variant="violet">
            <x-slot:icon>
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </x-slot:icon>
        </x-page-header>

        <!-- Table of Contents -->
        <x-table-card variant="violet">
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Table of Contents') }}</h2>
                <div class="grid gap-3 md:grid-cols-2">
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Privacy Policy') }}</h3>
                        <ul class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <li><a href="#privacy-introduction" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">1. Introduction</a></li>
                            <li><a href="#privacy-information-collection" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">2. Information We Collect</a></li>
                            <li><a href="#privacy-how-we-use" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">3. How We Use Your Information</a></li>
                            <li><a href="#privacy-data-storage" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">4. Data Storage and Security</a></li>
                            <li><a href="#privacy-data-sharing" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">5. Data Sharing and Disclosure</a></li>
                            <li><a href="#privacy-user-rights" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">6. Your Rights and Choices</a></li>
                            <li><a href="#privacy-permissions" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">7. App Permissions</a></li>
                            <li><a href="#privacy-children" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">8. Children's Privacy</a></li>
                            <li><a href="#privacy-data-retention" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">9. Data Retention</a></li>
                            <li><a href="#privacy-international" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">10. International Data Transfers</a></li>
                            <li><a href="#privacy-updates" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">11. Changes to This Privacy Policy</a></li>
                            <li><a href="#privacy-contact" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">12. Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Terms of Service') }}</h3>
                        <ul class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <li><a href="#terms-introduction" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">1. Introduction</a></li>
                            <li><a href="#terms-acceptance" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">2. Acceptance of Terms</a></li>
                            <li><a href="#terms-user-accounts" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">3. User Accounts</a></li>
                            <li><a href="#terms-acceptable-use" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">4. Acceptable Use</a></li>
                            <li><a href="#terms-intellectual-property" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">5. Intellectual Property</a></li>
                            <li><a href="#terms-user-content" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">6. User Content</a></li>
                            <li><a href="#terms-service-availability" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">7. Service Availability</a></li>
                            <li><a href="#terms-limitation" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">8. Limitation of Liability</a></li>
                            <li><a href="#terms-termination" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">9. Termination</a></li>
                            <li><a href="#terms-governing-law" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">10. Governing Law</a></li>
                            <li><a href="#terms-changes" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">11. Changes to Terms</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Privacy Policy Section -->
        <x-table-card variant="violet">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Privacy Policy') }}</h2>
                </div>

                <!-- Introduction -->
                <section id="privacy-introduction" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['introduction']['title'] ?? 'Privacy Policy' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $privacyPolicy['introduction']['content'] ?? '' }}</p>
                </section>

                <!-- Information Collection -->
                <section id="privacy-information-collection" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['information_collection']['title'] ?? 'Information We Collect' }}</h3>
                    @if(isset($privacyPolicy['information_collection']['sections']))
                        @foreach($privacyPolicy['information_collection']['sections'] as $section)
                            <div class="mb-6 space-y-3">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $section['title'] ?? '' }}</h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                @if(isset($section['items']))
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($section['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </section>

                <!-- How We Use Information -->
                <section id="privacy-how-we-use" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['how_we_use_information']['title'] ?? 'How We Use Your Information' }}</h3>
                    @if(isset($privacyPolicy['how_we_use_information']['sections']))
                        <div class="space-y-4">
                            @foreach($privacyPolicy['how_we_use_information']['sections'] as $section)
                                <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $section['purpose'] ?? '' }}</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Data Storage -->
                <section id="privacy-data-storage" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['data_storage']['title'] ?? 'Data Storage and Security' }}</h3>
                    @if(isset($privacyPolicy['data_storage']['sections']))
                        @foreach($privacyPolicy['data_storage']['sections'] as $section)
                            <div class="mb-6 space-y-3">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $section['title'] ?? '' }}</h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                @if(isset($section['items']))
                                    <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($section['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </section>

                <!-- Data Sharing -->
                <section id="privacy-data-sharing" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['data_sharing']['title'] ?? 'Data Sharing and Disclosure' }}</h3>
                    @if(isset($privacyPolicy['data_sharing']['sections']))
                        <div class="space-y-4">
                            @foreach($privacyPolicy['data_sharing']['sections'] as $section)
                                <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $section['scenario'] ?? '' }}</h4>
                                    <p class="mb-2 text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                    @if(isset($section['items']))
                                        <ul class="list-disc space-y-1 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                            @foreach($section['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- User Rights -->
                <section id="privacy-user-rights" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['user_rights']['title'] ?? 'Your Rights and Choices' }}</h3>
                    @if(isset($privacyPolicy['user_rights']['sections']))
                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach($privacyPolicy['user_rights']['sections'] as $section)
                                <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $section['right'] ?? '' }}</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Permissions -->
                <section id="privacy-permissions" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['permissions']['title'] ?? 'App Permissions' }}</h3>
                    <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">{{ $privacyPolicy['permissions']['description'] ?? '' }}</p>
                    @if(isset($privacyPolicy['permissions']['permissions']))
                        <div class="space-y-3">
                            @foreach($privacyPolicy['permissions']['permissions'] as $permission)
                                <div class="flex items-start gap-3 rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-violet-500 text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $permission['permission'] ?? '' }}</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $permission['purpose'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Children's Privacy -->
                <section id="privacy-children" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['children_privacy']['title'] ?? 'Children\'s Privacy' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $privacyPolicy['children_privacy']['content'] ?? '' }}</p>
                </section>

                <!-- Data Retention -->
                <section id="privacy-data-retention" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['data_retention']['title'] ?? 'Data Retention' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $privacyPolicy['data_retention']['content'] ?? '' }}</p>
                </section>

                <!-- International Transfers -->
                <section id="privacy-international" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['international_transfers']['title'] ?? 'International Data Transfers' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $privacyPolicy['international_transfers']['content'] ?? '' }}</p>
                </section>

                <!-- Policy Updates -->
                <section id="privacy-updates" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['policy_updates']['title'] ?? 'Changes to This Privacy Policy' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $privacyPolicy['policy_updates']['content'] ?? '' }}</p>
                </section>

                <!-- Contact Information -->
                <section id="privacy-contact" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $privacyPolicy['contact_information']['title'] ?? 'Contact Us' }}</h3>
                    <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">{{ $privacyPolicy['contact_information']['content'] ?? '' }}</p>
                    @if(isset($privacyPolicy['contact_information']['contact_details']))
                        <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-6 dark:border-violet-900/50 dark:bg-violet-900/20">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <a href="mailto:{{ $privacyPolicy['contact_information']['contact_details']['email'] ?? '' }}" class="text-sm font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300">
                                        {{ $privacyPolicy['contact_information']['contact_details']['email'] ?? '' }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $privacyPolicy['contact_information']['contact_details']['company'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </x-table-card>

        <!-- Terms of Service Section -->
        <x-table-card variant="violet">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Terms of Service') }}</h2>
                </div>

                <!-- Introduction -->
                <section id="terms-introduction" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['introduction']['title'] ?? 'Terms of Service' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['introduction']['content'] ?? '' }}</p>
                </section>

                <!-- Acceptance -->
                <section id="terms-acceptance" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['acceptance']['title'] ?? 'Acceptance of Terms' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['acceptance']['content'] ?? '' }}</p>
                </section>

                <!-- User Accounts -->
                <section id="terms-user-accounts" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['user_accounts']['title'] ?? 'User Accounts' }}</h3>
                    @if(isset($termsOfService['user_accounts']['sections']))
                        <div class="space-y-4">
                            @foreach($termsOfService['user_accounts']['sections'] as $section)
                                <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $section['requirement'] ?? '' }}</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Acceptable Use -->
                <section id="terms-acceptable-use" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['acceptable_use']['title'] ?? 'Acceptable Use' }}</h3>
                    @if(isset($termsOfService['acceptable_use']['prohibited_activities']))
                        <div class="rounded-xl border border-red-200 bg-red-50/30 p-6 dark:border-red-900/50 dark:bg-red-900/20">
                            <h4 class="mb-4 text-base font-semibold text-red-900 dark:text-red-400">{{ __('Prohibited Activities') }}</h4>
                            <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                                @foreach($termsOfService['acceptable_use']['prohibited_activities'] as $activity)
                                    <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </section>

                <!-- Intellectual Property -->
                <section id="terms-intellectual-property" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['intellectual_property']['title'] ?? 'Intellectual Property' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['intellectual_property']['content'] ?? '' }}</p>
                </section>

                <!-- User Content -->
                <section id="terms-user-content" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['user_content']['title'] ?? 'User Content' }}</h3>
                    @if(isset($termsOfService['user_content']['sections']))
                        <div class="space-y-4">
                            @foreach($termsOfService['user_content']['sections'] as $section)
                                <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-4 dark:border-violet-900/50 dark:bg-violet-900/20">
                                    <h4 class="mb-2 text-base font-semibold text-gray-900 dark:text-white">{{ $section['right'] ?? '' }}</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $section['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Service Availability -->
                <section id="terms-service-availability" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['service_availability']['title'] ?? 'Service Availability' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['service_availability']['content'] ?? '' }}</p>
                </section>

                <!-- Limitation of Liability -->
                <section id="terms-limitation" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['limitation_of_liability']['title'] ?? 'Limitation of Liability' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['limitation_of_liability']['content'] ?? '' }}</p>
                </section>

                <!-- Termination -->
                <section id="terms-termination" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['termination']['title'] ?? 'Termination' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['termination']['content'] ?? '' }}</p>
                </section>

                <!-- Governing Law -->
                <section id="terms-governing-law" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['governing_law']['title'] ?? 'Governing Law' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['governing_law']['content'] ?? '' }}</p>
                </section>

                <!-- Changes to Terms -->
                <section id="terms-changes" class="scroll-mt-20">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $termsOfService['changes_to_terms']['title'] ?? 'Changes to Terms' }}</h3>
                    <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $termsOfService['changes_to_terms']['content'] ?? '' }}</p>
                </section>
            </div>
        </x-table-card>

        <!-- Footer -->
        <x-table-card variant="violet">
            <div class="text-center space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <svg class="h-5 w-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Last Updated: :date', ['date' => $appInfo['last_updated'] ?? '2024-12-19']) }}
                    </p>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('SendaSnap Android App - Privacy Policy & Terms of Service') }}
                </p>
            </div>
        </x-table-card>
    </div>

    @push('scripts')
        <script>
            (function() {
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


<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(shippingCompanyId = null) {
        $wire.$dispatch('open-shipping-company-modal', { shippingCompanyId: shippingCompanyId })
    },
    openPreview(shippingCompanyId = null) {
        $wire.$dispatch('open-shipping-company-preview', { shippingCompanyId: shippingCompanyId })
    },
    confirmDelete(shippingCompanyId, companyName = null) {
        return window.confirmDelete(shippingCompanyId, companyName);
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Shipping Companies')"
        :description="__('Manage and view shipping companies')"
        variant="indigo">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-6 9 6v9a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Shipping Company') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="indigo">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by company name, city, or country...') }}"
                    icon="magnifying-glass" />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="companyTypeFilter" placeholder="{{ __('All Types') }}">
                    <option value="">{{ __('All Types') }}</option>
                    <option value="Transporter">{{ __('Transporter') }}</option>
                    <option value="Shipping Line">{{ __('Shipping Line') }}</option>
                    <option value="Workshop">{{ __('Workshop') }}</option>
                    <option value="PROVIDER">{{ __('PROVIDER') }}</option>
                    <option value="EXPENSE">{{ __('EXPENSE') }}</option>
                    <option value="COURIER">{{ __('COURIER') }}</option>
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="companyStatusFilter" placeholder="{{ __('All Status') }}">
                    <option value="">{{ __('All Status') }}</option>
                    <option value="Active">{{ __('Active') }}</option>
                    <option value="Inactive">{{ __('Inactive') }}</option>
                </flux:select>
            </div>

            @if($search || $companyTypeFilter || $companyStatusFilter)
                <div class="flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if($search || $companyTypeFilter || $companyStatusFilter)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
                @if($search)
                    <flux:badge color="violet" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
                @endif
                @if($companyTypeFilter)
                    <flux:badge color="blue" size="sm">{{ __('Type:') }} {{ $companyTypeFilter }}</flux:badge>
                @endif
                @if($companyStatusFilter)
                    <flux:badge color="green" size="sm">{{ __('Status:') }} {{ $companyStatusFilter }}</flux:badge>
                @endif
            </div>
        @endif

        <!-- Table View (2xl and above) -->
        <div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20"
             wire:key="shipping-companies-table-{{ md5(($search ?? '').'|'.($companyTypeFilter ?? '').'|'.($companyStatusFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Company Name') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Type') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                            {{ __('Location') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($shippingCompanies as $shippingCompany)
                        <x-shipping-company-table-row :shippingCompany="$shippingCompany" wire:key="shipping-company-{{ $shippingCompany->id }}" />
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-6 9 6v9a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No shipping companies found') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Stacked View (below 2xl) -->
        <div class="2xl:hidden bg-white/50 backdrop-blur-sm dark:bg-gray-900/20"
             wire:key="shipping-companies-stacked-{{ md5(($search ?? '').'|'.($companyTypeFilter ?? '').'|'.($companyStatusFilter ?? '')) }}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
                @forelse($shippingCompanies as $shippingCompany)
                    <x-shipping-company-card :shippingCompany="$shippingCompany" :rounded="true" wire:key="shipping-company-card-{{ $shippingCompany->id }}" />
                @empty
                    <div class="col-span-full p-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-6 9 6v9a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No shipping companies found') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $shippingCompanies->links() }}
        </div>
    </x-table-card>

    <!-- Shipping Company Modal -->
    <livewire:shipping-companies.shipping-company-modal />

    <!-- Shipping Company Preview -->
    <livewire:shipping-companies.shipping-company-preview />
</div>



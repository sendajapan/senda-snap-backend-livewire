<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(userId = null) {
        $wire.$dispatch('open-user-modal', { userId: userId })
    },
    openPreview(userId = null) {
        $wire.$dispatch('open-user-preview', { userId: userId })
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Users Management')"
        :description="__('Manage all system users and their roles')"
        variant="blue">
        <x-slot:icon>
            <flux:icon.users class="h-7 w-7 text-white" />
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New User') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="blue">
        <div class="mb-4 flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <flux:input wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('Search by name or email...') }}" icon="magnifying-glass"/>
            </div>
            <div class="sm:w-48">
                <flux:select wire:model.live="roleFilter">
                    <option value="">{{ __('All Roles') }}</option>
                    <option value="admin">{{ __('Admin') }}</option>
                    <option value="manager">{{ __('Manager') }}</option>
                    <option value="employee">{{ __('Employee') }}</option>
                    <option value="client">{{ __('Client') }}</option>
                </flux:select>
            </div>
        </div>

        <!-- Table View (2xl and above) -->
        <div
            class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">
                        {{ __('S/N') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        {{ __('Name') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        {{ __('Email') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        {{ __('Role') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden md:table-cell">
                        {{ __('Vendor') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden md:table-cell">
                        {{ __('Phone') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden md:table-cell">
                        {{ __('Created At') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                        {{ __('Updated At') }}
                    </th>
                    <th class="whitespace-nowrap px-3 2xl:px-4 py-3 2xl:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-32">
                        {{ __('Actions') }}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                @forelse($users as $index => $user)
                    <x-user-table-row :user="$user" :index="$users->firstItem() + $index" wire:key="user-row-{{ $user->id }}"/>
                @empty
                    <tr>
                        <td colspan="9" class="px-3 2xl:px-4 py-8 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div
                                    class="flex h-icon-lg w-icon-lg items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ __('No users found') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Stacked View (below 2xl) -->
        <div class="2xl:hidden bg-white/50 backdrop-blur-sm dark:bg-gray-900/20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @forelse($users as $user)
                    <x-user-card :user="$user" :rounded="true" wire:key="user-card-{{ $user->id }}"/>
                @empty
                    <div class="col-span-full p-8 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div
                                class="flex h-icon-lg w-icon-lg items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ __('No users found') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </x-table-card>

    <!-- User Modal -->
    <livewire:users.user-modal/>

    <!-- User Preview -->
    <livewire:users.user-preview/>
</div>



<div class="flex h-full w-full flex-1 flex-col gap-6 p-6" x-data="{
    openModal(userId = null) {
        $wire.$dispatch('open-user-modal', { userId: userId })
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Users Management')"
        :description="__('Manage all system users and their roles')"
        variant="blue">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New User') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="blue">
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search by name or email...') }}" icon="magnifying-glass" />
                </div>
                <div class="w-48">
                    <flux:select wire:model.live="roleFilter">
                        <option value="">{{ __('All Roles') }}</option>
                        <option value="admin">{{ __('Admin') }}</option>
                        <option value="manager">{{ __('Manager') }}</option>
                        <option value="employee">{{ __('Employee') }}</option>
                        <option value="client">{{ __('Client') }}</option>
                    </flux:select>
                </div>
            </div>

            <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Email') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Role') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Phone') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Created At') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Updated At') }}
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                        @forelse($users as $user)
                            <x-user-table-row :user="$user" />
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __('No users found') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('Try adjusting your search or filters') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </x-table-card>

    <!-- User Modal -->
    <livewire:users.user-modal />
</div>

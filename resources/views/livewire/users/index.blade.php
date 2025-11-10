<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
    <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Users') }}</flux:heading>
                <flux:text>{{ __('Manage all system users') }}</flux:text>
            </div>
            <flux:button :href="route('users.create')" icon="plus" wire:navigate>
                {{ __('Add User') }}
            </flux:button>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Search by name or email...') }}" icon="magnifying-glass" />
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

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ __('Email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ __('Role') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ __('Phone') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="size-10 flex-shrink-0">
                                            <div class="flex size-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                    {{ $user->initials() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <flux:badge :color="match($user->role) {
                                        'admin' => 'red',
                                        'manager' => 'blue',
                                        'employee' => 'green',
                                        default => 'gray',
                                    }">
                                        {{ ucfirst($user->role) }}
                                    </flux:badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $user->phone ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <flux:button size="sm" variant="ghost" :href="route('users.edit', $user)" icon="pencil" wire:navigate>
                                        {{ __('Edit') }}
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('No users found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
</div>

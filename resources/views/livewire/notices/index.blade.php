<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(noticeId = null) {
        $wire.$dispatch('open-notice-modal', { noticeId: noticeId })
    },
    confirmDelete(noticeId, message = null) {
        return window.confirmDelete(noticeId, message);
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Notices')"
        :description="__('Manage broadcast notices that appear on the top bar')"
        variant="violet">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Notice') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="violet">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search notices...') }}"
                    icon="magnifying-glass" />
            </div>
        </div>

        <!-- Notices List -->
        <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Message') }}
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Schedule') }}
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Created By') }}
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($notices as $notice)
                        <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-violet-50/50 hover:to-purple-50/50 dark:hover:from-violet-900/10 dark:hover:to-purple-900/10" wire:key="notice-{{ $notice->id }}">
                            <td class="px-6 py-4">
                                <div class="max-w-md truncate text-sm text-gray-900 dark:text-white">
                                    {{ $notice->message }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge color="{{ $notice->is_active ? 'emerald' : 'gray' }}" size="sm" class="font-semibold">
                                    {{ $notice->is_active ? __('Active') : __('Inactive') }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                @if($notice->starts_at || $notice->ends_at)
                                    <div class="flex flex-col gap-1">
                                        @if($notice->starts_at)
                                            <span>{{ __('From:') }} {{ $notice->starts_at->format('M d, Y H:i') }}</span>
                                        @endif
                                        @if($notice->ends_at)
                                            <span>{{ __('To:') }} {{ $notice->ends_at->format('M d, Y H:i') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">{{ __('Always') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $notice->creator->name ?? __('Unknown') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <!-- Edit Button -->
                                    <button @click="openModal({{ $notice->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-violet-700/60 bg-violet-500/10 p-1.5 transition-all duration-200 hover:border-violet-700 hover:bg-violet-500/20 hover:shadow-lg hover:shadow-violet-700/30" title="{{ __('Edit Notice') }}">
                                        <svg class="h-4 w-4 text-violet-700 transition-all duration-200 group-hover:text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button @click="confirmDelete({{ $notice->id }}, '{{ addslashes(Str::limit($notice->message, 50)) }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-notice', { noticeId: {{ $notice->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete Notice') }}">
                                        <svg class="h-4 w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No notices found') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Create a notice to broadcast to all users') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $notices->links() }}
        </div>
    </x-table-card>

    <!-- Notice Modal -->
    <livewire:notices.notice-modal />
</div>

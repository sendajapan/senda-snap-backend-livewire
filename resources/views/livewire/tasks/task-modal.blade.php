<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-xl bg-white/90">

                <div class="flex h-full flex-col overflow-y-auto border-l border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 shadow-2xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-400 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $isEditing ? __('Edit Task') : __('Add New Task') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $isEditing ? __('Update task information') : __('Create a new task') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto">
                        <div class="space-y-6 p-6">
                            <!-- Title -->
                            <div>
                                <flux:input wire:model="title" label="{{ __('Task Title') }}" placeholder="{{ __('Enter task title') }}" required />
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <flux:textarea wire:model="description" label="{{ __('Description') }}" placeholder="{{ __('Enter task description') }}" rows="4" />
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Assigned To (Multiple) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Assign To (Multiple)') }}
                                </label>
                                <div class="space-y-2 max-h-48 overflow-y-auto rounded-lg border border-gray-300 bg-white p-3 dark:border-gray-600 dark:bg-gray-800">
                                    @foreach($users as $user)
                                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 rounded p-2 transition-colors">
                                            <input 
                                                type="checkbox" 
                                                wire:model="assigned_to" 
                                                value="{{ $user->id }}"
                                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="flex items-center gap-2 flex-1">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-6 w-6 rounded-lg object-cover ring-2 ring-emerald-200 dark:ring-emerald-800">
                                                @else
                                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
                                                        <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                                            {{ $user->initials() }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ ucfirst($user->role) }})</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('assigned_to')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('assigned_to.*')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status & Priority -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:select wire:model="status" label="{{ __('Status') }}" required>
                                        <option value="pending">{{ __('Pending') }}</option>
                                        <option value="running">{{ __('Running') }}</option>
                                        <option value="completed">{{ __('Completed') }}</option>
                                        <option value="cancelled">{{ __('Cancelled') }}</option>
                                    </flux:select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <flux:select wire:model="priority" label="{{ __('Priority') }}" required>
                                        <option value="low">{{ __('Low') }}</option>
                                        <option value="medium">{{ __('Medium') }}</option>
                                        <option value="high">{{ __('High') }}</option>
                                        <option value="urgent">{{ __('Urgent') }}</option>
                                    </flux:select>
                                    @error('priority')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Work Date & Time -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:input type="date" wire:model="work_date" label="{{ __('Work Date') }}" />
                                    @error('work_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <flux:input type="time" wire:model="work_time" label="{{ __('Work Time') }}" />
                                    @error('work_time')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Due Date -->
                            <div>
                                <flux:input type="date" wire:model="due_date" label="{{ __('Due Date') }}" />
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50">
                            <div class="flex items-center justify-end gap-3">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check">
                                    {{ $isEditing ? __('Update Task') : __('Create Task') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


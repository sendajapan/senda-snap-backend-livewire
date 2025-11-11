<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

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
                                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 rounded transition-colors">
                                            <input type="checkbox" wire:model="assigned_to" value="{{ $user->id }}" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="flex items-center gap-2 flex-1">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-5 w-5 rounded-lg object-cover ring-2 ring-emerald-200 dark:ring-emerald-800">
                                                @else
                                                    <div class="flex h-5 w-5 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
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
                                    <flux:input type="time" wire:model="work_time" label="{{ __('Work Time') }}" step="1" />
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

                            <!-- File Attachments -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Attachments') }}
                                </label>

                                <!-- Existing Attachments -->
                                @if(!empty($existingAttachments))
                                    <div class="space-y-2 mb-3">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Uploaded Files') }}</p>
                                        @foreach($existingAttachments as $attachment)
                                            <div class="flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50/50 p-3 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-500">
                                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $attachment['file_name'] }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ __('Uploaded by') }} {{ $attachment['uploader']['name'] ?? 'Unknown' }} • {{ \Carbon\Carbon::parse($attachment['created_at'])->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 flex-shrink-0">
                                                    <a href="{{ Storage::disk('public')->url($attachment['file_path']) }}" 
                                                       target="_blank" 
                                                       class="rounded-lg p-2 text-emerald-600 hover:bg-emerald-100 dark:text-emerald-400 dark:hover:bg-emerald-900/20">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                    </a>
                                                    <button type="button" 
                                                            wire:click="deleteAttachment({{ $attachment['id'] }})"
                                                            class="rounded-lg p-2 text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/20">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Upload New Files -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <input type="file" 
                                               wire:model="attachments" 
                                               multiple 
                                               id="file-upload" 
                                               class="hidden">
                                        <label for="file-upload" 
                                               class="inline-flex cursor-pointer items-center gap-2 rounded-lg border-2 border-dashed border-emerald-300 bg-emerald-50/50 px-4 py-3 text-sm font-medium text-emerald-700 transition-colors hover:bg-emerald-100 dark:border-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-900/30">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            {{ __('Choose Files') }}
                                        </label>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Max 10MB per file') }}</span>
                                    </div>

                                    <!-- New Files Preview -->
                                    @if(!empty($attachments))
                                        <div class="space-y-2">
                                            @foreach($attachments as $index => $file)
                                                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800" wire:key="attachment-{{ $index }}">
                                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                                            @if(is_object($file) && method_exists($file, 'getClientOriginalName'))
                                                                {{ $file->getClientOriginalName() }}
                                                            @else
                                                                {{ __('File') }} {{ $index + 1 }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <button type="button" 
                                                            wire:click="removeNewAttachment({{ $index }})"
                                                            class="flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div wire:loading wire:target="attachments" class="text-sm text-emerald-600 dark:text-emerald-400">
                                        {{ __('Uploading files...') }}
                                    </div>

                                    @error('attachments.*')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
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


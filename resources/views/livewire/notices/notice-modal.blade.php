<div>
    <flux:modal wire:model="open" class="max-w-lg">
        <div class="space-y-4 sm:space-y-6">
            <div>
                <flux:heading size="lg" class="text-base sm:text-lg">
                    {{ $isEditing ? __('Edit Notice') : __('Create Notice') }}
                </flux:heading>
                <flux:text class="mt-1 sm:mt-2 text-xs sm:text-sm">
                    {{ $isEditing ? __('Update the notice message and settings.') : __('Create a new broadcast notice for all users.') }}
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-3 sm:space-y-4">
                <!-- Message -->
                <flux:field>
                    <flux:label>{{ __('Message') }} <span class="text-red-500">*</span></flux:label>
                    <flux:textarea
                        wire:model="message"
                        rows="3"
                        placeholder="{{ __('Enter the notice message...') }}"
                        maxlength="500" />
                    <flux:error name="message" />
                    <flux:description>{{ __('Maximum 500 characters') }}</flux:description>
                </flux:field>

                <!-- Active Status -->
                <flux:field>
                    <flux:switch wire:model="is_active" label="{{ __('Active') }}" description="{{ __('Only active notices are displayed') }}" />
                </flux:field>

                <!-- Schedule -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                    <flux:field>
                        <flux:label>{{ __('Start Date') }}</flux:label>
                        <flux:input type="datetime-local" wire:model="starts_at" />
                        <flux:error name="starts_at" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('End Date') }}</flux:label>
                        <flux:input type="datetime-local" wire:model="ends_at" />
                        <flux:error name="ends_at" />
                    </flux:field>
                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 pt-3 sm:pt-4">
                    <flux:button variant="ghost" wire:click="closeModal" type="button" class="text-xs sm:text-sm px-2 sm:px-3 py-1.5 sm:py-2">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary" class="text-xs sm:text-sm px-2 sm:px-3 py-1.5 sm:py-2">
                        {{ $isEditing ? __('Update Notice') : __('Create Notice') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

<div>
    <flux:modal wire:model="open" class="max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $isEditing ? __('Edit Notice') : __('Create Notice') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditing ? __('Update the notice message and settings.') : __('Create a new broadcast notice for all users.') }}
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-4">
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
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
                <div class="flex justify-end gap-3 pt-4">
                    <flux:button variant="ghost" wire:click="closeModal" type="button">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ $isEditing ? __('Update Notice') : __('Create Notice') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

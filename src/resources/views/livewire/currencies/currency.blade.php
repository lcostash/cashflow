<div>
    <flux:modal name="currency" class="mmin-w-[22rem]">
        <form wire:submit.prevent="save">
            <div class="space-y-3">
                <div>
                    <flux:heading size="lg">{{ $heading }}</flux:heading>
                    <flux:text class="mt-2">{{ $subheading }}</flux:text>
                    <flux:separator class="mt-2" variant="subtle" />
                </div>

                @csrf
                <flux:input label="{{ __('Code') }}" placeholder="{{ __('ex: GBP') }}" wire:model="code" />
                <flux:input label="{{ __('Name') }}" placeholder="{{ __('ex: British Pound Sterling') }}"
                    wire:model="name" />

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button size="sm" variant="ghost">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" size="sm" variant="primary">{{ __('Save') }}</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>

<section class="relative w-full">
    @include('partials.section-heading', [
        'title' => __('Currencies'),
        'subtitle' => __('Manage your currencies'),
    ])

    @session('success')
    @include('partials.toastr', [
        'timeout' => 3000,
        'message' => $value,
        'class' => 'bg-green-600 text-white',
    ])
    @endsession('success')

    <livewire:currencies.currency />

    <x-button floating-action-button wire:click="add()" tooltip="{{ __('Add Currency') }}" icon="plus" />

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left">
            <group>
                <col width="10%" />
                <col width="80%" />
                <col width="10%" />
            </group>
            <thead>
                <tr>
                    <th scope="col" class="p-2">{{ __('Code') }}</th>
                    <th scope="col" class="p-2">{{ __('Name') }}</th>
                    <th scope="col" class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($currencies as $currency)
                    <tr wire:key="currency-{{ $currency->id }}">
                        <td class="p-2">{{ $currency->code }}</td>
                        <td class="p-2">{{ $currency->name }}</td>
                        <td class="p-2 flex alighn-center justify-end">
                            <flux:button size="sm" icon="pencil-square" variant="subtle" class="cursor-pointer"
                                tooltip="{{ __('Edit :code', ['code' => $currency->code]) }}"
                                wire:click="edit({{ $currency }})" />
                            <flux:button size="sm" icon="trash" variant="subtle" class="cursor-pointer"
                                tooltip="{{ __('Delete :code', ['code' => $currency->code]) }}"
                                wire:click="confirm({{ $currency }})" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-2 text-center">
                            {{ __('No currencies found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $currencies->links() }}
        </div>

        <flux:modal name="confirm" class="min-w-[22rem]">
            <div class="space-y-3">
                <div>
                    <flux:heading size="lg">{{ __('Delete currency?') }}</flux:heading>
                    <flux:text class="mt-2">
                        {{ __('Are you sure you want to delete this currency?') }}<br />
                        {{ __('This action cannot be undone.') }}
                    </flux:text>
                    <flux:separator class="mt-2" variant="subtle" />
                </div>

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button size="sm" variant="ghost">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" size="sm" variant="danger" wire:click="delete()">
                        {{ __('Delete') }}</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</section>

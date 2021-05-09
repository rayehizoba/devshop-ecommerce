<div>
    <form wire:submit.prevent="submit">
        <div class="px-6 py-4">
            <div class="text-lg">
                {{ __($title) }}
            </div>

            <div class="mt-4 space-y-5">
                <div x-data="{}" x-init="() => setTimeout(() => $refs.autofocus.focus(), 250)">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input x-ref="autofocus" id="name" type="text" class="mt-1 block w-full" wire:model.defer="form.name" autocomplete="off" autofocus/>
                    <x-jet-input-error for="form.name" class="mt-2" />
                </div>
                <div class="w-20">
                    <x-jet-label for="order" value="{{ __('Order') }}" />
                    <x-jet-input id="order" type="number" min="1" placeholder="1" class="mt-1 block w-full" wire:model.defer="form.order"/>
                    <x-jet-input-error for="form.order" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right space-x-2">
            <x-jet-secondary-button type="button" wire:click="cancel" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>

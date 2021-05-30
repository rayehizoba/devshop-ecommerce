<div>
    <form wire:submit.prevent="submit">
        <div class="px-6 py-4">
            <div class="text-lg">
                {{ __($title) }}
            </div>

            <div class="mt-4 space-y-5">
                <div class="flex flex-col md:flex-row space-y-5 md:space-y-0 md:space-x-5">
                    <div class="space-y-2 md:w-1/2">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <div x-data="{}" x-init="() => setTimeout(() => $refs.autofocus.focus(), 250)">
                            <x-jet-input x-ref="autofocus" id="name" type="text" class="block w-full" wire:model.defer="form.name" autocomplete="off"/>
                        </div>
                        <x-jet-input-error for="name" />
                    </div>
                    <div class="space-y-2">
                        <x-jet-label for="order" value="{{ __('Order') }}" />
                        <x-jet-input id="order" type="number" min="1" placeholder="1" class="block w-20" wire:model.defer="form.order"/>
                        <x-jet-input-error for="order" />
                    </div>
                </div>
                <div class="space-y-2">
                    <x-jet-label for="summary" value="{{ __('Summary') }}" />
                    <x-jet-input id="summary" type="text" class="block w-full" wire:model.defer="form.summary"/>
                    <x-jet-input-error for="summary" />
                </div>
                <div class="space-y-2">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <x-input.trix id="description" wire:model.defer="form.description" />
                    <x-jet-input-error for="description" />
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

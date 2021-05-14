<div>
    <form wire:submit.prevent="submit">
        <div class="px-6 py-4">
            <div class="text-lg">
                {{ __($title) }}
            </div>

            <div class="mt-4 space-y-5">
                <div class="flex flex-col md:flex-row">
                    <div class="py-3 md:w-28">
                        <x-jet-label for="cover_image_path" value="{{ __('Cover Image') }}" />
                    </div>
                    <div class="w-3/4">
                        <x-jet-input id="cover_image_path" type="text" class="mt-1 block w-full" wire:model.defer="form.cover_image_path"/>
                        <x-jet-input-error for="form.cover_image_path" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="py-3 md:w-28">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                    </div>
                    <div x-data="{}" x-init="() => setTimeout(() => $refs.autofocus.focus(), 250)" class="w-3/4">
                        <x-jet-input x-ref="autofocus" id="name" type="text" class="mt-1 block w-full" wire:model.defer="form.name" autocomplete="off"/>
                        <x-jet-input-error for="form.name" class="mt-2" />
                    </div>
                </div>
{{--                <div class="flex flex-col md:flex-row">--}}
{{--                    <div class="py-3 md:w-28">--}}
{{--                        <x-jet-label for="order" value="{{ __('Order') }}" />--}}
{{--                    </div>--}}
{{--                    <div class="w-20">--}}
{{--                        <x-jet-input id="order" type="number" min="1" placeholder="1" class="block w-full" wire:model.defer="form.order"/>--}}
{{--                        <x-jet-input-error for="form.order" class="mt-2" />--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="flex flex-col md:flex-row">--}}
{{--                    <div class="py-3 md:w-28">--}}
{{--                        <x-jet-label for="summary" value="{{ __('Summary') }}" />--}}
{{--                    </div>--}}
{{--                    <div class="w-full lg:w-1/2 flex-1 lg:flex-initial">--}}
{{--                        <x-jet-input id="summary" type="text" class="block w-full" wire:model.defer="form.summary"/>--}}
{{--                        <x-jet-input-error for="form.summary" class="mt-2" />--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="flex flex-col md:flex-row">
                    <div class="py-3 md:w-28">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                    </div>
                    <div class="w-full flex-1">
                        <x-input.trix id="description" wire:model.defer="form.description" />
                        <x-jet-input-error for="form.description" class="mt-2" />
                    </div>
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

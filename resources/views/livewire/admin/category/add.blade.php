<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:w-2/3 lg:w-2/5">
                <form wire:submit.prevent="submit">
                    <div class="bg-white px-4 py-5 shadow sm:p-6 sm:rounded-tl-md sm:rounded-tr-md space-y-5">
                        <div>
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="off" autofocus/>
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                        <div class="w-20">
                            <x-jet-label for="order" value="{{ __('Order') }}" />
                            <x-jet-input id="order" type="number" min="1" placeholder="1" class="mt-1 block w-full" wire:model="order"/>
                            <x-jet-input-error for="order" class="mt-2" />
                        </div>
                    </div>

                    <div class="bg-gray-50 flex items-center justify-end px-4 py-3 shadow sm:px-6 sm:rounded-bl-md sm:rounded-br-md text-right">
                        <div x-data="{ shown: false, timeout: null }" x-init="window.livewire.find('Qo78FZwdiQ4I7meA4n5D').on('saved', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000);  })" x-show.transition.opacity.out.duration.1500ms="shown" style="display: none;" class="text-sm text-gray-600 mr-3">
                            Saved.
                        </div>

                        <button wire:loading.attr="disabled" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

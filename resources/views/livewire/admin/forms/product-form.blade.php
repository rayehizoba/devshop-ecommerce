<div x-data="
{
  tab: 'Product',
  tabs: ['Product', 'Description', 'Screenshots'],
  getTabs() {
    return this.tabs
  },
  setTab(tab) {
    this.tab = tab
  },
  getActive() {
    return this.tab
  },
}
">
    <form wire:submit.prevent="submit">
        <div class="py-4">
            <div class="px-6 text-lg">
                {{ __($title) }}
            </div>

            <div class="lg:col-span-2 xl:col-span-3">
                <ul class="inline-flex w-full border-b border-b-300 select-none px-6 space-x-6">
                    <template hidden x-for="item in getTabs()" :key="item">
                        <li @click="setTab(item)" class="relative py-2 cursor-pointer hover:opacity-75">
                            <div :class="{ 'border-b-4 -mb-1': getActive() === item }"
                                 class="absolute top-0 left-0 w-full h-full border-b-0 border-gray-900 transition-all ease-out duration-75"></div>
                            <span x-text="item" class="uppercase tracking-widest text-xs font-semibold"></span>
                        </li>
                    </template>
                </ul>
                <div class="py-5">
                    {{-- Product Tab Content --}}
                    <section x-show="getActive() === 'Product'">
                        <div class="px-6 space-y-4">
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="md:w-28">
                                    <x-jet-label for="name" value="{{ __('Name') }}"/>
                                </div>
                                <div x-data="{}" x-init="() => setTimeout(() => $refs.autofocus.focus(), 250)"
                                     class="lg:w-3/4">
                                    <x-jet-input x-ref="autofocus" id="name" type="text"
                                                 class="mt-1 md:mt-0 block w-full" wire:model.defer="form.name"
                                                 autocomplete="off"/>
                                    <x-jet-input-error for="form.name" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="md:w-28">
                                    <x-jet-label for="cover_image_path" value="{{ __('Cover Image') }}"/>
                                </div>
                                <div class="lg:w-3/4">
                                    <x-jet-input id="cover_image_path" type="text" class="mt-1 md:mt-0 block w-full"
                                                 wire:model.defer="form.cover_image_path"/>
                                    <x-jet-input-error for="form.cover_image_path" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="md:w-28">
                                    <x-jet-label for="web_url" value="{{ __('Web URL') }}"/>
                                </div>
                                <div class="lg:w-3/4">
                                    <x-jet-input id="web_url" type="url" class="mt-1 md:mt-0 block w-full"
                                                 wire:model.defer="form.web_url"/>
                                    <x-jet-input-error for="form.web_url" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="md:w-28">
                                    <x-jet-label for="play_store_url" value="{{ __('Play Store URL') }}"/>
                                </div>
                                <div class="lg:w-3/4">
                                    <x-jet-input id="play_store_url" type="url" class="mt-1 md:mt-0 block w-full"
                                                 wire:model.defer="form.play_store_url"/>
                                    <x-jet-input-error for="form.play_store_url" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="md:w-28">
                                    <x-jet-label for="app_store_url" value="{{ __('App Store URL') }}"/>
                                </div>
                                <div class="lg:w-3/4">
                                    <x-jet-input id="app_store_url" type="text" class="mt-1 md:mt-0 block w-full"
                                                 wire:model.defer="form.app_store_url"/>
                                    <x-jet-input-error for="form.app_store_url" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-28 md:py-3">
                                    <x-jet-label for="category_ids" value="{{ __('Categories') }}"/>
                                </div>
                                <div class="md:w-1/2">
                                    <x-input.select class="mt-1 md:mt-0 w-full" wire:model="form.category_ids"
                                                    id="category_ids" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </x-input.select>
                                    <x-jet-input-error for="form.category_ids" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-28 md:py-3">
                                    <x-jet-label value="{{ __('Licenses') }}"/>
                                </div>
                                <div class="mt-1 md:mt-0 md:w-1/2 border border-gray-300 rounded-lg px-3 shadow-sm">
                                    <x-table>
                                        <x-slot name="head">
                                            <x-table.heading>
                                                License
                                            </x-table.heading>
                                            <x-table.heading>
                                                Price ($)
                                            </x-table.heading>
                                        </x-slot>
                                        <x-slot name="body">
                                            @foreach ($licenses as $license)
                                                <x-table.row>
                                                    <x-table.cell>
                                                        <p>
                                                            {{ $license->name }}
                                                        </p>
                                                        <small class="text-gray-500">
                                                            {{ $license->summary }}
                                                        </small>
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        <x-jet-input
                                                                wire:model.defer="form.license_prices.{{ $license->id }}.price"
                                                                type="number" class="mt-1 block w-24 text-sm"/>
                                                    </x-table.cell>
                                                </x-table.row>
                                            @endforeach
                                        </x-slot>
                                    </x-table>
                                    <x-jet-input-error for="form.license_prices" class="mt-2"/>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Product Description Tab Content --}}
                    <section x-show="getActive() === 'Description'">
                        <div class="px-6 space-y-4">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-28 md:py-3">
                                    <x-jet-label for="description" value="{{ __('Description') }}"/>
                                </div>
                                <div class="w-full flex-1">
                                    <x-input.trix id="description" wire:model.defer="form.description"
                                                  style="min-height: 300px; max-height: 500px"
                                                  class="mt-1 md:mt-0 overflow-y-auto"/>
                                    <x-jet-input-error for="form.description" class="mt-2"/>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Product Screenshots Tab Content --}}
                    <section x-show="getActive() === 'Screenshots'">
                        <div class="px-6 space-y-5">
                            comming soon...
                        </div>
                    </section>
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



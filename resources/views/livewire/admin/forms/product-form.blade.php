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

                            <div class="flex flex-col md:flex-row-reverse space-y-6 md:space-y-0">
                                <div class="md:w-2/6 space-y-6">
                                    <div class="space-y-2">
                                        <x-jet-label for="cover_image_path" value="{{ __('Cover Image') }}"/>

                                        @if (!isset($form['cover_image_path']))
                                            <div class="border shadow-sm rounded-lg bg-gray-100 h-56 flex items-center">
                                                <p class="text-gray-400 p-5 text-center text-xs">
                                                    Please set a cover image by clicking the "Browse" button
                                                </p>
                                            </div>
                                        @elseif (is_string($form['cover_image_path']))
                                            <img src="{{ Storage::url($form['cover_image_path']) }}" alt=""
                                                 class="border shadow-sm rounded-lg">
                                        @elseif($form['cover_image_path']->temporaryUrl())
                                            <img class="border shadow-sm rounded-lg"
                                                 src="{{ $form['cover_image_path']->temporaryUrl() }}">
                                        @endif

                                        <x-jet-secondary-button @click="$refs.file.click()">
                                            Browse...
                                        </x-jet-secondary-button>
                                        <input class="hidden" x-ref="file" type="file" id="cover_image_path"
                                               wire:model="form.cover_image_path"/>
                                        <x-jet-input-error for="cover_image_path"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label for="category_ids" value="{{ __('Categories') }}"/>
                                        <x-input.select class="w-full md:h-56" wire:model="form.category_ids"
                                                        id="category_ids" multiple>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </x-input.select>
                                        <x-jet-input-error for="category_ids"/>
                                    </div>
                                </div>
                                <div class="md:w-4/6 md:mr-16 space-y-6">
                                    <div class="space-y-2" x-data="{}"
                                         x-init="() => setTimeout(() => $refs.autofocus.focus(), 250)">
                                        <x-jet-label for="name" value="{{ __('Name') }}"/>
                                        <x-jet-input x-ref="autofocus" id="name" type="text" class="w-full"
                                                     wire:model.defer="form.name" autocomplete="off"/>
                                        <x-jet-input-error for="name"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label for="web_url" value="{{ __('Web URL') }}"/>
                                        <x-jet-input id="web_url" type="url" class="w-full"
                                                     wire:model.defer="form.web_url" placeholder="https://"/>
                                        <x-jet-input-error for="web_url"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label for="play_store_url" value="{{ __('Play Store URL') }}"/>
                                        <x-jet-input id="play_store_url" type="url" class="w-full"
                                                     wire:model.defer="form.play_store_url" placeholder="https://"/>
                                        <x-jet-input-error for="play_store_url"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label for="app_store_url" value="{{ __('App Store URL') }}"/>
                                        <x-jet-input id="app_store_url" type="text" class="w-full"
                                                     wire:model.defer="form.app_store_url" placeholder="https://"/>
                                        <x-jet-input-error for="app_store_url"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label value="{{ __('Licenses') }}"/>
                                        <div class="border border-gray-300 rounded-lg px-3 shadow-sm">
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
                                        </div>
                                        <x-jet-input-error for="license_prices"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Product Description Tab Content --}}
                    <section x-show="getActive() === 'Description'">
                        <div class="px-6 space-y-2">
                            <x-input.trix id="description" wire:model.defer="form.description"
                                          style="min-height: 300px; max-height: 500px"
                                          class="mt-1 md:mt-0 overflow-y-auto"/>
                            <x-jet-input-error for="description"/>
                        </div>
                    </section>

                    {{-- Product Screenshots Tab Content --}}
                    <section x-show="getActive() === 'Screenshots'">
                        <div class="px-6 space-y-5">
                            @if(count($productScreenshots) || count($screenshotFiles))
                                <ul class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($productScreenshots as $screenshot)
                                        <li class="h-64 bg-gray-200 bg-center bg-contain bg-no-repeat relative"
                                            style="background-image: url({{ Storage::url($screenshot['path']) }})">
                                            <x-jet-danger-button
                                                    wire:click="removeProductScreenshot({{ $screenshot['id'] }})"
                                                    class="absolute bottom-0 right-0 m-2">
                                                Remove
                                            </x-jet-danger-button>
                                        </li>
                                    @endforeach
                                    @foreach($screenshotFiles as $screenshot)
                                        <li class="h-64 bg-gray-200 bg-center bg-contain bg-no-repeat relative"
                                            style="background-image: url({{ $screenshot->temporaryUrl() }})">
                                            <x-jet-danger-button wire:click="removeScreenshotFile({{ $loop->index }})"
                                                                 class="absolute bottom-0 right-0 m-2">
                                                Remove
                                            </x-jet-danger-button>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xl text-gray-500 flex items-center">
                                    <i class="mdi mdi-view-grid-plus text-gray-300 text-4xl"></i>
                                    Click the "Browse Files" button to choose multiple files.
                                </p>
                            @endif

                            <x-jet-secondary-button @click="$refs.screenshots.click()">
                                Browse Files...
                            </x-jet-secondary-button>
                            <input class="hidden" x-ref="screenshots" type="file" wire:model="screenshotFiles" multiple>
                            <x-jet-input-error for="screenshots.*"/>
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



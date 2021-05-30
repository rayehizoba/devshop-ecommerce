<div x-data="{ tab: @entangle('tab') }">
    <form wire:submit.prevent="submit">
        <div class="py-4">
            <div class="px-6 text-lg">
                {{ __($title) }}
            </div>

            <div class="lg:col-span-2 xl:col-span-3">
                <ul class="inline-flex w-full border-b border-b-300 select-none px-6 space-x-6">
                    @foreach($tabs as $each)
                        <li @click="tab = '{{ $each }}'"
                            class="relative py-2 cursor-pointer hover:opacity-75 @if($tabErrors[$each]) text-red-500 @endif">
                            <div :class="{ 'border-b-4 -mb-1': tab === '{{ $each }}' }"
                                 class="absolute top-0 left-0 w-full h-full border-b-0 border-gray-900 transition-all ease-out duration-75"></div>
                            <span class="uppercase tracking-widest text-xs font-semibold">{{ $each }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="py-5">
                    {{-- Product Tab Content--}}
                    <section x-show="tab == 'product'">
                        <div class="px-6 space-y-4">
                            <div class="flex flex-col md:flex-row-reverse space-y-6 md:space-y-0">
                                <div class="md:w-2/6 space-y-6">
                                    <div class="space-y-2">
                                        <x-jet-label for="cover_image_path" value="{{ __('Cover Image') }}"/>

                                        @if ($files['cover_image'] && $files['cover_image']->isPreviewable())
                                            {{--                                             temp file preview--}}
                                            <img class="border shadow-sm rounded-lg"
                                                 src="{{ $files['cover_image']->temporaryUrl() }}">
                                        @elseif (!isset($form['cover_image_path']))
                                            {{--                                             placeholder--}}
                                            <div class="border shadow-sm rounded-lg bg-gray-100 h-56 flex items-center">
                                                <p class="text-gray-400 p-5 text-center text-xs">
                                                    Please set a cover image by clicking the "Browse" button
                                                </p>
                                            </div>
                                        @else
                                            {{--                                             existing cover image--}}
                                            <img src="{{ Storage::url($form['cover_image_path']) }}"
                                                 class="border shadow-sm rounded-lg">
                                        @endif

                                        <x-jet-input-error for="cover_image"/>
                                        <x-jet-input-error for="cover_image_path"/>

                                        <x-jet-secondary-button @click="$refs.cover_image.click()">
                                            Browse...
                                        </x-jet-secondary-button>
                                        <input class="hidden" x-ref="cover_image" type="file" id="cover_image"
                                               wire:model="files.cover_image" accept="image/*"/>
                                    </div>
                                    <div class="space-y-2">
                                        <x-jet-label for="categories" value="{{ __('Categories') }}"/>
                                        <x-input.select class="w-full md:h-56" wire:model="associated.categories"
                                                        id="categories" multiple>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </x-input.select>
                                        <x-jet-input-error for="categories"/>
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
                                        <x-jet-label value="{{ __('Product Licenses') }}"/>
                                        <div class="border border-gray-300 rounded-lg px-3 shadow-sm">
                                            <x-table style="min-width: 550px">
                                                <x-slot name="head">
                                                    <x-table.heading>
                                                        License Type
                                                    </x-table.heading>
                                                    <x-table.heading>
                                                        Price ($)
                                                    </x-table.heading>
                                                    <x-table.heading>
                                                        Package (*.zip)
                                                    </x-table.heading>
                                                    <x-table.heading>
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
                                                                        wire:model.defer="associated.licenses.{{ $license->id }}.price"
                                                                        type="number" class="mt-1 block w-24 text-sm"/>
                                                                <x-jet-input-error
                                                                        for="licenses.{{ $license->id }}.price"/>
                                                            </x-table.cell>
                                                            <x-table.cell>
                                                                <div class="flex flex-col text-xs items-start space-y-2">
                                                                    @if(isset($associated['licenses'][$license->id]['package_path']))
                                                                        <a href="{{ Storage::url($associated['licenses'][$license->id]['package_path']) }}"
                                                                           target="_blank"
                                                                           class="text-blue-500 hover:underline font-medium">
                                                                            <i class="mdi mdi-download"></i>
                                                                            Download Existing
                                                                        </a>
                                                                    @endif
                                                                    <button type="button"
                                                                            wire:loading.class="animate-pulse"
                                                                            wire:loading.attr="disabled"
                                                                            wire:target="files.packages.{{ $license->id }}"
                                                                            x-on:click.prevent="$refs.package_{{ $license->id }}.click()"
                                                                            class="text-blue-500 hover:underline font-medium">
                                                                        <i class="mdi mdi-folder-upload"></i>
                                                                        @if (isset($files['packages'][$license->id]))
                                                                            {{ $files['packages'][$license->id]->getClientOriginalName() }}
                                                                        @else
                                                                            Upload New
                                                                        @endif
                                                                    </button>
                                                                    <input type="file"
                                                                           wire:model="files.packages.{{ $license->id }}"
                                                                           x-ref="package_{{ $license->id }}"
                                                                           class="hidden"
                                                                           accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed"/>
                                                                    <x-jet-input-error
                                                                            for="files.packages.{{ $license->id }}"/>
                                                                    <x-jet-input-error
                                                                            for="licenses.{{ $license->id }}.package_path"/>
                                                                </div>
                                                            </x-table.cell>
                                                            <x-table.cell>
                                                                @if(isset($associated['licenses'][$license->id]))
                                                                    <button type="button" title="clear row"
                                                                            wire:click="removeAssociatedLicense({{ $license->id }})"
                                                                            class="text-gray-400 hover:text-gray-500 w-6 h-6 focus:outline-none focus:ring">
                                                                        <i class="mdi mdi-close text-xl"></i>
                                                                    </button>
                                                                @endif
                                                            </x-table.cell>
                                                        </x-table.row>
                                                    @endforeach
                                                </x-slot>
                                            </x-table>
                                        </div>
                                        <x-jet-input-error for="licenses"/>
                                        <x-jet-input-error for="packages"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Product Description Tab Content--}}
                    <section x-show="tab == 'description'">
                        <div class="px-6 space-y-2">
                            <x-input.trix id="description" wire:model.defer="form.description"
                                          style="min-height: 300px; max-height: 500px"
                                          class="mt-1 md:mt-0 overflow-y-auto"/>
                            <x-jet-input-error for="description"/>
                        </div>
                    </section>

                    {{-- Product Screenshots Tab Content--}}
                    <section x-show="tab == 'screenshots'">
                        <div class="px-6 space-y-5">
                            <div>
                                @if(count($associated['screenshots']) || count($files['screenshots']))
                                    <ul class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($associated['screenshots'] as $screenshot)
                                            <li class="h-64 bg-gray-200 bg-center bg-contain bg-no-repeat relative"
                                                style="background-image: url({{ Storage::url($screenshot['path']) }})">
                                                <x-jet-danger-button
                                                        wire:click="removeAssociatedScreenshot({{ $screenshot['id'] }})"
                                                        class="absolute bottom-0 right-0 m-2">
                                                    Remove
                                                </x-jet-danger-button>
                                            </li>
                                        @endforeach
                                        @foreach($files['screenshots'] as $screenshot)
                                            @if($screenshot->isPreviewable())
                                                <li wire:key="{{ $screenshot->temporaryUrl() }}"
                                                    class="h-64 bg-gray-200 bg-center bg-contain bg-no-repeat relative"
                                                    style="background-image: url({{ $screenshot->temporaryUrl() }})">
                                                    <x-jet-danger-button
                                                            wire:click="removeScreenshotFile({{ $loop->index }})"
                                                            class="absolute bottom-0 right-0 m-2">
                                                        Remove
                                                    </x-jet-danger-button>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-xl text-gray-500 flex items-center">
                                        <i class="mdi mdi-view-grid-plus text-gray-400 text-4xl"></i>
                                        Click the "Browse Files" button to choose multiple files.
                                    </p>
                                @endif
                            </div>

                            <x-jet-input-error for="screenshots.*"/>

                            <x-jet-secondary-button @click="$refs.screenshots.click()">
                                Browse Files...
                            </x-jet-secondary-button>
                            <input class="hidden" x-ref="screenshots" type="file" wire:model="files.screenshots"
                                   multiple accept="image/*">
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



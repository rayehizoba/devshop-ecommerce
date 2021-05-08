<div class="absolute top-0 left-0 w-full h-full pointer-events-none" x-data="{ show: $wire.entangle('isOpen').defer }" x-cloak>
    <div class="max-w-7xl mx-auto relative">
        <div x-show="show" x-on:click.away="show = false"
             class="pointer-events-auto absolute left-0 sm:left-auto top-0 right-0 m-5 border border-gray-100 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-start space-x-4">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="mdi mdi-check text-green-600 text-2xl"></i>
                    </div>

                    <div class="flex flex-1 space-x-10">
                        <div class="flex-1">
                            <h3>
                                {{ $title }}
                            </h3>
                            <div class="text-sm text-gray-500">
                                {{ $content }}
                            </div>
                        </div>
                        <i x-on:click="show = false"
                           class="mdi mdi-close text-2xl pl-2 pb-2 text-gray-700 cursor-pointer hover:opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

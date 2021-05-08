<div>
    <x-jet-modal wire:model="isOpen" :max-width="$maxWidth">
        @if($isOpen)
            @livewire($type, compact('params'))
        @endif
    </x-jet-modal>
</div>

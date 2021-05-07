<x-jet-dialog-modal wire:model="editMode">
    <x-slot name="title">
        @json($category)
        {{ __('API Token') }}
    </x-slot>

    <x-slot name="content">
        <div>
            {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('editMode', false)" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>

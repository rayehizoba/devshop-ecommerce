<div>
    <x-jet-confirmation-modal wire:model="isOpen" max-width="sm">
        <x-slot name="title">
            {{ __($params['title']) }}
        </x-slot>

        <x-slot name="content">
            {{ __($params['content']) }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="close" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>

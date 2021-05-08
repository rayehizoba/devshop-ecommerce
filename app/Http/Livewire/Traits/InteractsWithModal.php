<?php
namespace App\Http\Livewire\Traits;

trait InteractsWithModal
{
    protected function openModal(string $form, $params = [], string $modalSize = null)
    {
        $this->emitTo('components.modal', 'showModal', $form, $params, $modalSize);
    }

    protected function closeModal()
    {
        $this->emitTo('components.modal', 'closeModal');
        $this->closeDeleteModal();
    }

    protected function openDeleteModal($id, string $title, string $content)
    {
        $this->emitTo('components.delete-modal', 'showModal', $id, $title, $content);
    }

    protected function closeDeleteModal()
    {
        $this->emitTo('components.delete-modal', 'closeModal');
    }
}

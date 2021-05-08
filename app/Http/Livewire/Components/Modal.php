<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    public $type = '';
    public $params = [];
    public $maxWidth = null;

    protected $listeners = [
        'showModal' => 'open',
        'closeModal' => 'close',
        'showDeleteModal' => 'openDelete',
        'closeDeleteModal' => 'closeDelete',
    ];

    public function open(string $type, array $params = [], string $maxWidth = null)
    {
        $this->isOpen = true;
        $this->type = $type;
        $this->params = $params;

        if ($maxWidth) {
            $this->maxWidth = $maxWidth;
        }
    }

    public function openDelete($params, string $form = null)
//    public function openDelete($params, string $form = 'forms.base-delete-form')
    {
        return $this->open($form, $params);
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.components.modal');
    }
}

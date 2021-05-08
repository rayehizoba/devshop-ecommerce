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
    ];

    public function open(string $type, array $params = [], string $maxWidth = null)
    {
        $this->type = $type;
        $this->params = $params;
        if ($maxWidth) {
            $this->maxWidth = $maxWidth;
        }
        $this->isOpen = true;
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

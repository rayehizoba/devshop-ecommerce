<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class DeleteModal extends Component
{
    public $isOpen = false;
    public $params = [
        'id' => null,
        'title' => '',
        'content' => ''
    ];

    protected $listeners = [
        'showModal' => 'open',
        'closeModal' => 'close',
    ];

    public function open($id, string $title, string $content)
    {
        $this->params = [
            'id' => $id,
            'title' => $title,
            'content' => $content,
        ];
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function delete()
    {
        $this->emit('list:unset', $this->params['id']);
        $this->close();
    }

    public function render()
    {
        return view('livewire.components.delete-modal');
    }
}

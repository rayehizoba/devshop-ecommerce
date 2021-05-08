<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Toast extends Component
{
    public $isOpen = false;
    public $title = '';
    public $content = '';

    protected $listeners = [
        'toast' => 'open',
    ];


    public function open(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
        $this->isOpen = true;
    }


    public function render()
    {
        return view('livewire.components.toast');
    }
}

<?php

namespace App\Http\Livewire\Admin\Forms;

use Livewire\Component;

class BaseForm extends Component {
    public $form = [];

    public function mount(array $params = [])
    {
        if (isset($params['id'])) {
            foreach (array_keys($this->form) as $key) {
                $this->form[$key] = $params[$key];
            }
        }
    }
}

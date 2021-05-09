<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\License;
use Livewire\Component;

class LicenseForm extends Component
{
    use InteractsWithModal;

    public $title;

    public $form = [
        'id' => null,
        'name' => '',
        'order' => 1,
        'summary' => '',
        'description' => '',
    ];

    protected $rules = [
        'form.id' => 'nullable',
        'form.name' => 'required',
        'form.order' => 'required',
        'form.summary' => 'required',
        'form.description' => 'required',
    ];


    public function mount(array $params = [])
    {
        parent::mount($params);

        $this->title = isset($params['id']) ? 'Update License' : 'Add A License';

        if (isset($params['id'])) {
            $this->form = [
                'id' => $params['id'],
                'name' => $params['name'],
                'order' => $params['order'],
                'summary' => $params['summary'],
                'description' => $params['description'],
            ];
        }
    }


    public function submit()
    {
        $data = $this->validate()['form'];

        $license = License::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        $this->closeModal();

        $this->emit('list:refresh');
        $this->emit('toast', 'License Saved', $license['name'].' has been saved.');

    }


    public function cancel()
    {
        $this->closeModal();
    }


    public function render()
    {
        return view('livewire.admin.forms.license-form');
    }
}

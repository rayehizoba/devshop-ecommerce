<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\License;
use Illuminate\Support\Arr;

class LicenseForm extends BaseForm
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


    public function rules()
    {
        return Arr::dot(['form' => License::validationRules()]);
    }


    public function mount(array $params = [])
    {
        parent::mount($params);
        $this->title = isset($params['id']) ? 'Update License' : 'Add A License';
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

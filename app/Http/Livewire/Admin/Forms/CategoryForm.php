<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\Category;
use Livewire\Component;

class CategoryForm extends Component
{
    use InteractsWithModal;

    public $title;

    public $form = [
        'id' => null,
        'name' => '',
        'order' => 1,
    ];

    protected $rules = [
        'form.id' => 'nullable',
        'form.name' => 'required',
        'form.order' => 'required'
    ];


    public function mount(array $params = [])
    {
        parent::mount($params);

        $this->title = isset($params['id']) ? 'Update Category' : 'Add A Category';

        if (isset($params['id'])) {
            $this->form = [
                'id' => $params['id'],
                'name' => $params['name'],
                'order' => $params['order'],
            ];
        }
    }


    public function submit()
    {
        $data = $this->validate()['form'];

        Category::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        $this->emit('toast', 'Category Saved');
        $this->emit('list:refresh');
        $this->closeModal();
    }


    public function cancel()
    {
        $this->closeModal();
    }


    public function render()
    {
        return view('livewire.admin.forms.category-form');
    }
}

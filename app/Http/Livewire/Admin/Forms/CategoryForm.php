<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\Category;
use Illuminate\Support\Arr;

class CategoryForm extends BaseForm
{
    use InteractsWithModal;

    public $title;

    public $form = [
        'id' => null,
        'name' => '',
        'order' => 1,
    ];


    public function rules()
    {
        return Arr::dot(['form' => Category::validationRules()]);
    }


    public function mount(array $params = [])
    {
        parent::mount($params);
        $this->title = isset($params['id']) ? 'Update Category' : 'Add A Category';
    }


    public function submit()
    {
        $data = $this->validate()['form'];
        $category = Category::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        $this->closeModal();

        $this->emit('list:refresh');
        $this->emit('toast', 'Category Saved', $category['name'].' has been saved.');

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

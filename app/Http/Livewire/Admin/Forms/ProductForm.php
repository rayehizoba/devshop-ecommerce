<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\License;
use App\Models\Product;
use Illuminate\Support\Arr;

class ProductForm extends BaseForm
{
    use InteractsWithModal;

    public $title;

    public $form = [
        'id'                => null,
        'cover_image_path'  => '',
        'name'              => '',
        'web_url'           => null,
        'play_store_url'    => null,
        'app_store_url'     => null,
        'description'       => '',
    ];

    public function rules()
    {
        return Arr::dot(['form' => Product::validationRules()]);
    }


    public function mount(array $params = [])
    {
        parent::mount($params);
        $this->title = isset($params['id']) ? 'Update Product' : 'Add A Product';
    }


    public function submit()
    {
        $data = $this->validate()['form'];

        $product = Product::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        $this->closeModal();

        $this->emit('list:refresh');
        $this->emit('toast', 'Product Saved', $product['name'].' has been saved.');

    }


    public function cancel()
    {
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.forms.product-form');
    }
}

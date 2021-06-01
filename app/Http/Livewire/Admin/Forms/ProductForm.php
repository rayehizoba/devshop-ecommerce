<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\Category;
use App\Models\License;
use App\Models\Product;
use App\Models\ProductScreenshot;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProductForm extends BaseForm
{
    use InteractsWithModal, WithFileUploads;

    public $title;

    public $tabs = ['product', 'description', 'screenshots'];
    public $tab;

    public $form = [
        'id' => null,
        'cover_image_path' => null,
        'name' => '',
        'web_url' => null,
        'play_store_url' => null,
        'app_store_url' => null,
        'description' => '',
    ];

    public $associated = [
        'categories' => [],
        'licenses' => [],
        'screenshots' => [],
    ];

    public $files = [
        'cover_image' => null,
        'screenshots' => [],
        'packages' => [],
    ];

    public function mount(array $params = [])
    {
        // mount $form params using BaseForm::mount
        parent::mount($params);

        $this->tab = $this->tabs[0];
        $this->title = isset($params['id']) ? 'Update Product' : 'Add A Product';

        // load associated models
        if (isset($params['id'])) {
            $product = Product::find($params['id']);
            $this->associated['screenshots'] = $product->screenshots;
            $this->associated['categories'] = $product->categories()->pluck('id');
            foreach ($product->licenses as $license) {
                $this->associated['licenses'][$license->id] = $license->pivot;
            }
        }
    }

    public function submit()
    {
        // validate files data
        $files = Validator::make($this->files, [
            'cover_image' => 'nullable|image|max:1024', // 1MB Max
            'screenshots.*' => 'image|max:1024',
            'packages.*' => 'file|mimes:zip',
        ])->validate();

        // store validated package files
        if (isset($files['packages'])) {
            foreach ($files['packages'] as $license_id => $package) {
                $this->associated['licenses'][$license_id]['package_path'] = $package->store('packages', 'public');
            }
        }

        // validate associated data
        $associated = Validator::make($this->associated, [
            'categories' => 'required',
            'licenses' => 'required',
            'licenses.*.price' => 'required|numeric',
            'licenses.*.package_path' => 'required',
        ])->validate();

        // store validated cover image file
        if ($files['cover_image'] instanceof TemporaryUploadedFile) {
            $this->form['cover_image_path'] = $files['cover_image']->store('products', 'public');
        }

        // validate form data
        $data = Validator::make($this->form, [
            'id' => 'nullable',
            'cover_image_path' => 'required',
            'name' => [
                'required',
                isset($this->form['id'])
                    ? Rule::unique('products')->ignore($this->form['id'])
                    : Rule::unique('products')
            ],
            'web_url' => 'required_without_all:play_store_url,app_store_url',
            'play_store_url' => 'required_without_all:web_url,app_store_url',
            'app_store_url' => 'required_without_all:web_url,play_store_url',
            'description' => 'required',
        ])->validate();

        // update or create model
        $product = Product::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        // sync associated categories
        $product->categories()->sync($associated['categories']);

        // sync associated licenses
        $product->licenses()->sync($associated['licenses']);

        // store validated screenshot files
        foreach ($this->files['screenshots'] as $screenshot) {
            ProductScreenshot::create([
                'product_id' => $product->id,
                'path' => $screenshot->store('screenshots', 'public')
            ]);
        }

        $this->closeModal();

        $this->emit('list:refresh');
        $this->emit('toast', 'Product Saved', '\'' . $product['name'] . '\' has been saved.');

    }

    public function removeAssociatedScreenshot(ProductScreenshot $screenshot)
    {
        $screenshot->delete();
        $this->associated['screenshots'] = array_filter(
            $this->associated['screenshots'],
            function ($each) use ($screenshot) {
                return $each['id'] != $screenshot->id;
            });
    }

    public function removeAssociatedLicense($id)
    {
        unset($this->associated['licenses'][$id]);
    }

    public function removeScreenshotFile($id)
    {
        unset($this->files['screenshots'][$id]);
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function render()
    {
        $tabErrors = [];
        foreach ($this->tabs as $tab) {
            $tabErrors[$tab] = $this->_hasErrors($tab);
        }
        return view('livewire.admin.forms.product-form', [
            'categories' => Category::orderBy('order')->get(),
            'licenses' => License::orderBy('order')->get(),
            'tabErrors' => $tabErrors
        ]);
    }

    private function _hasErrors($tab)
    {
        $errors = $this->getErrorBag();

        switch ($tab) {
            case 'product':
                return (
                    $errors->has('categories')
                    || $errors->has('licenses')
                    || $errors->has('licenses.*')
                    || $errors->has('name')
                    || $errors->has('cover_image_path')
                    || $errors->has('web_url')
                    || $errors->has('play_store_url')
                    || $errors->has('app_store_url')
                );

            case 'description':
                return $errors->has('description');

            case 'screenshots':
                return $errors->has('screenshots.*');

            default:
                return false;
        }
    }
}

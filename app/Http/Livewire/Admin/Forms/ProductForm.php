<?php

namespace App\Http\Livewire\Admin\Forms;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\Category;
use App\Models\License;
use App\Models\Product;
use App\Models\ProductScreenshot;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProductForm extends BaseForm
{
    use InteractsWithModal, WithFileUploads;

    public $title;

    public $form = [
        'id' => null,
        'cover_image_path' => null,
        'name' => '',
        'web_url' => null,
        'play_store_url' => null,
        'app_store_url' => null,
        'description' => '',
        'category_ids' => [],
        'license_prices' => [],
    ];

    public $productScreenshots = [];

    public $screenshotFiles = [];

    public function mount(array $params = [])
    {
        parent::mount($params);
        $this->title = isset($params['id']) ? 'Update Product' : 'Add A Product';
        $this->productScreenshots = $params['screenshots'] ?? [];
    }

    public function submit()
    {
        $data = Validator::make($this->form, [
            'id' => 'nullable',
            'cover_image_path' => $this->form['cover_image_path'] instanceof TemporaryUploadedFile
                ? 'image|max:1024' : 'required',
            'name' => 'required',
            'web_url' => 'nullable',
            'play_store_url' => 'nullable',
            'app_store_url' => 'nullable',
            'description' => 'required',
            'category_ids' => 'required',
            'license_prices' => 'required',
        ])->validate();

        if ($this->form['cover_image_path'] instanceof TemporaryUploadedFile) {
            $data['cover_image_path'] = $data['cover_image_path']->store('products', 'public');
        }

        $product = Product::updateOrCreate(
            ['id' => $data['id']],
            $data
        );

        if (isset($data['category_ids'])) {
            $product->categories()->sync($data['category_ids']);
        }

        if (isset($data['license_prices'])) {
            $product->licenses()->sync(
                array_filter($data['license_prices'], fn($each) => is_numeric($each['price']))
            );
        }

        foreach ($this->screenshotFiles as $screenshot) {
            ProductScreenshot::create([
                'product_id' => $product->id,
                'path' => $screenshot->store('screenshots', 'public')
            ]);
        }

        $this->closeModal();

        $this->emit('list:refresh');
        $this->emit('toast', 'Product Saved', '\'' . $product['name'] . '\' has been saved.');

    }

    public function removeProductScreenshot(ProductScreenshot $productScreenshot)
    {
        $productScreenshot->delete();
        $this->productScreenshots = array_filter($this->productScreenshots, function($each) use ($productScreenshot) {
            return $each['id'] != $productScreenshot->id;
        });
    }

    public function removeScreenshotFile($id) { unset($this->screenshotFiles[$id]); }

    public function cancel() { $this->closeModal(); }

    public function render()
    {
        return view('livewire.admin.forms.product-form', [
            'categories' => Category::orderBy('order')->get(),
            'licenses' => License::orderBy('order')->get(),
        ]);
    }
}

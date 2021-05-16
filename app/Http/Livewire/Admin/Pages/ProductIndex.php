<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Http\Livewire\Traits\WithSortingAndPagination;
use App\Models\Category;
use App\Models\License;
use App\Models\Product;
use Livewire\Component;

class ProductIndex extends Component
{
    use WithSortingAndPagination, InteractsWithModal;

    public $search = '';
    public $filters = [
        'category' => null,
    ];

    protected $listeners = [
        'list:refresh' => '$refresh',
        'list:unset' => 'delete'
    ];


    protected $queryString = [
        'search' => ['except' => '']
    ];


    public function mount()
    {
        $this->setSort('id');
    }


    public function updatingFilters()
    {
        $this->resetPage();
    }


    private function _getProducts()
    {
        $query = Product::query();

        if ($this->filters['category']) {
            $query = Category::find($this->filters['category'])->products();
        }

        $query->search('name', $this->search);

        return $this->queryBuilder($query);
    }


    public function render()
    {
        return view('livewire.admin.pages.product-index', [
            'products' => $this->_getProducts(),
            'categories' => Category::orderBy('order')->get(),
        ]);
    }


    public function create()
    {
        $this->openModal('admin.forms.product-form', [], '4xl');
    }


    public function edit(Product $product)
    {
        $this->openModal('admin.forms.product-form', $product->toArray(), '4xl');
    }


    public function confirmDelete(Product $product)
    {
        $this->openDeleteModal(
            $product['id'],
            'Remove Product',
            'Are you sure you want to remove \''.$product['name'].'\' product?'
        );
    }


    public function delete(Product $product)
    {
        $product->delete();
        $this->emit('toast', 'Product Deleted', $product['name'].' has been deleted.');
    }

}

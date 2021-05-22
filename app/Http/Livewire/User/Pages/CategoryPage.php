<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{
    use WithPagination;

    public $category;

    public $orderby;

    protected $queryString = ['orderby'];

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->first();
    }

    private function _getProducts()
    {
        $query = $this->category->products();

        if ($this->orderby === 'date') {
            $query = $this->category->latestProducts();
        }

        if ($this->orderby === 'price') {
            $query = $this->category->cheapestProducts();
        }

        if ($this->orderby === 'price-desc') {
            $query = $this->category->premium_products;
        }

        return $query->paginate(2);
    }

    public function render()
    {
        return view('livewire.user.pages.category-page', [
            'products' => $this->_getProducts()
        ])->layout('layouts.guest');
    }
}

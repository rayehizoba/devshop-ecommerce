<?php

namespace App\Http\Livewire\Pages;

use App\Models\Category;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class CategoryPage extends Component
{
    public $category;

    public $orderby;

    protected $queryString = ['orderby'];

    public function mount($slug)
    {
//        $this->orderby = Config::get('constants.options.orderby')[0];

        $this->category = Category::where('slug', $slug)->first();
    }

    private function _getProducts()
    {
        if ($this->orderby === 'date') {
            return $this->category->latest_products;
        }

        if ($this->orderby === 'price') {
            return $this->category->cheapest_products;
        }

        if ($this->orderby === 'price-desc') {
            return $this->category->premium_products;
        }

        return $this->category->products;
    }

    public function render()
    {
        return view('livewire.pages.category-page', [
            'products' => $this->_getProducts()
        ])->layout('layouts.guest');
    }
}

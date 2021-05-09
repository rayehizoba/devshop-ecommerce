<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Http\Livewire\Traits\WithSortingAndPagination;
use App\Models\Category;
use Livewire\Component;

class CategoryIndex extends Component
{
    use WithSortingAndPagination, InteractsWithModal;

    public $search = '';

    protected $listeners = [
        'list:refresh' => '$refresh',
        'list:unset' => 'delete'
    ];


    protected $queryString = [
        'search' => ['except' => '']
    ];


    public function mount()
    {
        $this->setSort('order');
    }


    public function render()
    {
        return view('livewire.admin.pages.category-index', [
            'categories' => $this->queryBuilder(
                Category::search('name', $this->search)
            )
        ]);
    }


    public function create()
    {
        $this->openModal('admin.forms.category-form', [], 'sm');
    }


    public function edit(Category $category)
    {
        $this->openModal('admin.forms.category-form', $category, 'sm');
    }


    public function confirmDelete(Category $category)
    {
        $this->openDeleteModal(
            $category['id'],
            'Remove Category',
            'Are you sure you want to remove \''.$category['name'].'\' category?'
        );
    }


    public function delete(Category $category)
    {
        $category->delete();
        $this->emit('toast', 'Category Deleted', $category['name'].' has been deleted.');
    }


}

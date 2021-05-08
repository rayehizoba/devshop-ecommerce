<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;
    use InteractsWithModal;

    public $search = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';
    public $pageSize = 10;

    protected $listeners = [
        'list:refresh' => '$refresh'
    ];

    protected $queryString = ['search', 'sortField', 'sortDirection', 'pageSize'];


    public function render()
    {
        $categories = Category
            ::search('name', $this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->pageSize);

        return view('livewire.admin.pages.category-index', [
            'categories' => $categories,
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


    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function updatingPageSize()
    {
        $this->resetPage();
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }


    public function delete(Category $category)
    {
        $category->delete();
        session()->flash('message', 'Category successfully deleted.');
    }
}

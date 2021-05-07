<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';
    public $pageSize = 10;

    public $editMode = false;
    public $model = null;

    protected $queryString = ['search', 'sortField', 'sortDirection', 'pageSize'];

    public function setEdit($id = null)
    {
        $this->model = isset($id) ? Category::find($id) : $id;
        $this->editMode = true;
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
}

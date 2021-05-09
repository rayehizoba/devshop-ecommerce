<?php
namespace App\Http\Livewire\Traits;

use Livewire\WithPagination;

trait WithSortingAndPagination
{
    use WithPagination;

    public $sortField;
    public $sortDirection;
    public $pageSize = 10;

    public function setSort($field, $direction = 'asc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
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

    public function updatingPageSize()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function queryBuilder($query)
    {
        $sortEnabled = $this->sortField && $this->sortDirection;

        $query->when($sortEnabled, function ($q) {
            return $q->orderBy($this->sortField, $this->sortDirection);
        });

        return $query->paginate($this->pageSize);
    }

    public function getQueryString()
    {
        return array_merge([
            'sortField' => ['except' => ''],
            'sortDirection',
            'pageSize',
            'page' => ['except' => 1],
        ], $this->queryString);
    }
}

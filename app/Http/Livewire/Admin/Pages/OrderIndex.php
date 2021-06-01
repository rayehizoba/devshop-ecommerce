<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Http\Livewire\Traits\WithSortingAndPagination;
use App\Models\Order;
use Livewire\Component;

class OrderIndex extends Component
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
        $this->setSort('number', 'desc');
    }

    public function render()
    {
        return view('livewire.admin.pages.order-index', [
            'orders' => $this->queryBuilder(
                 Order::search(['number', 'name', 'email'], $this->search)
            )
        ]);
    }
}

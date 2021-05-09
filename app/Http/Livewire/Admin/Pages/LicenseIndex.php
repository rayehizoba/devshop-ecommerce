<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\InteractsWithModal;
use App\Http\Livewire\Traits\WithSortingAndPagination;
use App\Models\License;
use Livewire\Component;

class LicenseIndex extends Component
{
    use WithSortingAndPagination, InteractsWithModal;


    protected $listeners = [
        'list:refresh' => '$refresh',
        'list:unset' => 'delete'
    ];


    public function mount()
    {
        $this->setSort('order');
    }


    public function render()
    {
        return view('livewire.admin.pages.license-index', [
            'licenses' => $this->queryBuilder(
                License::query()
            )
        ]);
    }


    public function create()
    {
        $this->openModal('admin.forms.license-form', [], '4xl');
    }


    public function edit(License $license)
    {
        $this->openModal('admin.forms.license-form', $license, '4xl');
    }


    public function confirmDelete(License $license)
    {
        $this->openDeleteModal(
            $license['id'],
            'Remove License',
            'Are you sure you want to remove \''.$license['name'].'\' license?'
        );
    }


    public function delete(License $license)
    {
        $license->delete();
        $this->emit('toast', 'License Deleted', $license['name'].' has been deleted.');
    }
}

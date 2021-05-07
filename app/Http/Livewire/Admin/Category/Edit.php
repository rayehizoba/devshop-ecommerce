<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public Category $category;

    public function render()
    {
        return view('livewire.admin.category.edit');
    }
}

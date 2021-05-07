<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Add extends Component
{
    public $name;
    public $order = 1;

    protected $rules = [
        'name' => 'required'
    ];

    public function submit()
    {
        $this->validate();
//
//        Category::create([
//            'name' => $this->name,
//            'order' => $this->order,
//        ]);
//
//        session()->flash('message', 'Category successfully added.');
//        return redirect()->route('admin.category.browse');
    }

    public function render()
    {
        return view('livewire.admin.category.add');
    }
}

<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Category\Add;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{

    public function test_category_can_be_added()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Add::class)
            ->set('name', 'foo')
            ->call('submit');

        $this->assertTrue(Category::whereName('foo')->exists());
    }
}

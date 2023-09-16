<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class RecipeCounter extends Component
{
    #[Reactive]
    public $recipes;

    public function render()
    {
        return view('livewire.recipe-counter');
    }
}

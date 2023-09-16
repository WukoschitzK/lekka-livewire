<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Recipe as Recipes;


class RecipesListing extends Component
{
    // TODO: add to presentation, reactive props (property inside of the listing comp. will be updated by default)
    public $recipes;

    public function mount($recipes)
    {
        $this->recipes = $recipes;
    }

    public function render()
    {
        return view('livewire.recipes-listing');
    }

    public function allRecipes()
    {
        $this->recipes = Recipes::all();

        return view(
            'livewire.recipes-listing',
            [
                'recipes' => $this->recipes
            ]
        );
    }

    public function userRecipes()
    {
        return view('livewire.recipes-listing');
    }
}

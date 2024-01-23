<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Step;
use App\Models\Ingredient;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use App\Models\Recipe as Recipes;

class RecipeForm extends Form
{
    use WithFileUploads;

    // TODO: add to presentation, validation in v3
    #[Rule('required|min:3')]
    public $title;

    #[Rule('required|min:3')]
    public $description;

    #[Rule('required|array|min:1')]
    public $ingredients = [];

    #[Rule('required')]
    public $steps = [];

    public $image;

    public $image_path = '';
    public $is_public = false;

    public function store()
    {
        // TODO: add to presentation, validation in v3
        $this->validate();

        // convert steps to json format
        // $this->steps = json_encode($this->steps);

        // convert ingredients to json format
        // $this->ingredients = json_encode($this->ingredients);

        if ($this->image) {
            $this->image->store('recipe_images', 'public');
        }


        // get storage path of stored image to show it in the view
        $this->image_path = 'storage/recipe_images/' . $this->image->hashName();

        $recipe = Recipes::create([
            'title' => $this->title,
            'description' => $this->description,
            // 'ingredients' => $this->ingredients,
            // 'steps' => $this->steps,
            'image_path' => $this->image_path,
            'is_public' => $this->is_public,
        ]);

        // create ingredient entry in table ingredient
        // $recipe->ingredient()->create([
        //     'item' => $this->ingredients
        // ]);
        foreach ($this->ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->item = $ingredientName['ingredientText'];
            $recipe->ingredients()->save($ingredient);
        }

        foreach ($this->steps as $stepItem) {
            $step = new Step();
            $step->item = $stepItem['stepText'];
            $recipe->steps()->save($step);
        }

        session()->flash('success', 'Recipe created successfully.');

        $this->reset('title', 'description');
    }

    // public function delete($id)
    // {
    //     Recipes::find($id)->delete();
    //     session()->flash('success', 'Recipe deleted successfully.');
    //     $this->reset('title', 'description', 'ingredients', 'steps', 'image_path', 'is_public');
    // }

    public function update($id)
    {
        $recipe = Recipes::findOrFail($id);

        if ($this->image) {
            $this->image->store('recipe_images', 'public');
            $this->image_path = 'storage/recipe_images/' . $this->image->hashName();
        }
        // get storage path of stored image to show it in the view

        $recipe->update([
            'title' => $this->title,
            'description' => $this->description,
            //'ingredients' => $this->ingredients,
            //'steps' => $this->steps,
            'image_path' => $this->image_path,
            'is_public' => $this->is_public,
        ]);

        // update all ingredients with current values
        foreach ($this->ingredients as $ingredientName) {
           
        }

        // foreach ($this->steps as $stepItem) {
        //     $step = new Step();
        //     $step->item = $stepItem['stepText'];
        //     $recipe->steps()->save($step);
        // }

        // update ingredient entry in table ingredient
        // $recipe->ingredients()->update([
        //     'item' => $this->ingredients
        // ]);

        // $recipe->steps()->update([
        //     'item' => $this->steps
        // ]);
    }
}

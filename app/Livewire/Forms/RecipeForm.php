<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use App\Models\Recipe as Recipes;
use Livewire\Form;
use Livewire\WithFileUploads;

class RecipeForm extends Form
{
    use WithFileUploads;

    // TODO: add to presentation, validation in v3
    #[Rule('required|min:3')]
    public $title;

    #[Rule('required|min:3')]
    public $description;

    #[Rule('required')]
    public $ingredients;

    #[Rule('required')]
    public $steps;

    public $image;

    public $image_path = '';
    public $is_public = false;


    public function store()
    {
        // TODO: add to presentation, validation in v3
        $this->validate();

        // convert steps to json format
        $this->steps = json_encode($this->steps);

        // convert ingredients to json format
        $this->ingredients = json_encode($this->ingredients);

        $this->image->store('recipe_images', 'public');

        // get storage path of stored image to show it in the view
        $this->image_path = 'storage/recipe_images/' . $this->image->hashName();

        $recipe = Recipes::create([
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'steps' => $this->steps,
            'image_path' => $this->image_path,
            'is_public' => $this->is_public,
        ]);

        // create ingredient entry in table ingredient
        $recipe->ingredient()->create([
            'item' => $this->ingredients
        ]);


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
        // $this->image->store('recipe_images', 'public');

        $this->image->store('recipe_images', 'public');

        // get storage path of stored image to show it in the view
        $this->image_path = 'storage/recipe_images/' . $this->image->hashName();

        $recipe->update([
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'steps' => $this->steps,
            'image_path' => $this->image_path,
            'is_public' => $this->is_public,
        ]);
    }
}

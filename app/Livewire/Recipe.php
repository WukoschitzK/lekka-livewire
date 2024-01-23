<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Recipe as Recipes;
use App\Livewire\Forms\RecipeForm;
use Livewire\WithFileUploads;


class Recipe extends Component
{
    use WithFileUploads;

    public $recipeId;

    // TODO: add to presentation form object (every input field must have form.title 
    // in blade and $this->form->title in livewire component)
    public RecipeForm $form;

    public $recipes;

    public $isOpen = false;

    public function render()
    {
        $this->recipes = Recipes::with('ingredients')->get();
        return view('livewire.recipe')->with([
            'recipes' => Recipes::all()
        ]);
    }

    // TODO: add to presentation, lazy loading of component with placeholder in v3
    public function placeholder()
    {
        return <<<'HTML'
        <div>PLACEHOLDER</div>
        HTML;

        // or return blade view for this
        // return view('livewire.placeholders.skeleton', $params);
    }

    public function create()
    {
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        // TODO: add to presentation, validation with form object
        $this->form->store();

        $this->closeModal();
    }

    //TODO update to form object
    public function edit($id)
    {
        $recipe = Recipes::with('ingredients')->with('steps')->findOrFail($id);

        $this->recipeId = $id;
        $this->form->title = $recipe->title;
        $this->form->description = $recipe->description;
        $this->form->ingredients = $recipe->ingredients()->get();
        $this->form->steps = $recipe->steps()->get();
        $this->form->image_path = $recipe->image_path;
        $this->form->is_public = $recipe->is_public;


        $ingredients = $recipe->ingredients()->get();
        foreach ($ingredients as $ingredient) {
            $this->form->ingredients[] = ['ingredientText' => $ingredient->item];
        }

        $steps = $recipe->steps()->get();
        foreach ($steps as $step) {
            $this->form->steps[] = ['stepText' => $step->item];
        }

        $this->openModal();
    }

    //TODO update to form object
    public function update()
    {
        if ($this->recipeId) {
            $this->form->update($this->recipeId);

            session()->flash('success', 'Recipe updated successfully.');
            $this->closeModal();
            $this->reset('title', 'description', 'ingredients', 'steps', 'image_path', 'is_public');
        }
    }

    // TODO fix 404 message after deleting recipe
    public function delete($id)
    {
        $recipe = Recipes::findOrFail($id);
        if ($recipe != null) {
            $recipe->delete();
        }
        session()->flash('success', 'Recipe deleted successfully.');
        $this->reset('title', 'description', 'ingredients', 'steps', 'image_path', 'is_public');
        // $this->form->delete($id);
    }
}

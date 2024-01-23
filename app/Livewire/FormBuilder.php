<?php

namespace App\Livewire;

use Livewire\Component;

class FormBuilder extends Component
{
    public $openFormBuilderModal = true;

    public function render()
    {
        return view('livewire.form-builder');
    }

    public function openFormBuilder()
    {
        $this->openModal();
    }

    public function openModal()
    {
        $this->openFormBuilderModal = true;
        // $this->resetValidation();
    }

    public function closeModal()
    {
        $this->openFormBuilderModal = false;
    }
}

<div>
    {{-- Success is as dangerous as failure. --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" class="absolute top-6 right-6">
            <div x-show="show" x-effect="if (show) setTimeout(function() {show = false}, 3000)"
                wire:transition.opacity.duration.500ms
                class="p-2 shadow-sm rounded-sm bg-teal-100 inline-block text-right">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- TODO: add to presentation, reactive props (property inside of the listing comp. will be updated by default) --}}
    <livewire:recipe-counter :$recipes />

    <div class="grid grid-cols-3 gap-4 justify-between">
        @foreach ($recipes as $recipe)
            {{-- @foreach ($recipe->ingredient as $ingredient)
                <h3>my ingredient: {{ $ingredient->item }}</h3>
            @endforeach --}}
            <div wire:key="{{ $recipe->id }}" class="p-6 shadow-md sm:rounded-lg ">
                <img src="{{ asset($recipe->image_path) }}" alt="foooood">
                <h3>{{ $recipe->title }}</h3>
                <p>{{ $recipe->description }}</p>
                <div class="flex">
                    <button class="" wire:click="edit({{ $recipe->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="ml-2 mt-0 w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                    <button class="" wire:click="delete({{ $recipe->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="ml-2 mt-0 w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="">
                <div class="max-w-xl">
                    <section>

                        <div class="my-4">
                            <button class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded"
                                wire:click="create">Add Recipe</button>
                        </div>


                        @if ($isOpen)
                            <div class="fixed inset-0 flex items-center justify-center z-50">
                                <div class="absolute inset-0 bg-black opacity-50"></div>
                                <div class="relative bg-gray-200 p-8 rounded shadow-lg w-1/2 my-16">
                                    <!-- Modal content goes here -->
                                    <svg wire:click.prevent="$set('isOpen', false)"
                                        class="ml-auto w-6 h-6 text-gray-900 dark:text-gray-900 cursor-pointer fill-current"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                        <path
                                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                    </svg>

                                    <h2 class="text-2xl font-bold mb-4">
                                        {{ $recipeId ? 'Edit Recipe' : 'Create Recipe' }}
                                    </h2>
                                    <form wire:submit.prevent="{{ $recipeId ? 'update' : 'store' }}">
                                        <div class="mb-4">
                                            <label for="title"
                                                class="block text-gray-700 font-bold mb-2">Title:</label>
                                            <input type="text" id="title" wire:model="form.title"
                                                class="w-full border border-gray-300 px-4 py-2 rounded">
                                            <span class="text-red-500">
                                                {{-- TODO: add to presentation, validation in v3 --}}
                                                @error('form.title')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description"
                                                class="block text-gray-700 font-bold mb-2">description:</label>
                                            <textarea id="description" wire:model="form.description" rows="4"
                                                class="w-full border border-gray-300 px-4 py-2 rounded"></textarea>
                                        </div>

                                        {{-- input fields for steps can be added dynamically with plus button --}}
                                        <div class="mb-4">
                                            <label for="steps"
                                                class="block text-gray-700 font-bold mb-2">Steps:</label>
                                            {{-- <textarea id="steps" wire:model="form.steps" rows="4" class="w-full border border-gray-300 px-4 py-2 rounded"></textarea> --}}

                                            <div x-data="{
                                                steps: @entangle('form.steps'),
                                                addNewStep() {
                                                    this.steps.push({
                                                        stepText: '',
                                                    });
                                                },
                                                removeStep(index) {
                                                    this.steps.splice(index, 1);
                                                }
                                            }">
                                                <template x-for="(step, index) in steps" :key="index">
                                                    <div>
                                                        <div x-text="index + 1"></div>
                                                        <textarea type="text" x-model="step.stepText" name="stepText" class="form-control"></textarea>
                                                        <button type="button" class="btn btn-danger btn-small"
                                                            @click="removeStep(index)">Remove</button>
                                                    </div>
                                                </template>

                                                <button type="button" class="btn btn-info" @click="addNewStep()">+ Add
                                                    Row</button>

                                                {{-- <textarea id="steps" wire:model="form.steps" rows="4" class="w-full border border-gray-300 px-4 py-2 rounded"></textarea> --}}


                                            </div>

                                        </div>



                                        {{-- input fields for ingredients can be added dynamically with plus button --}}

                                        <div class="mb-4">
                                            <label for="ingredients"
                                                class="block text-gray-700 font-bold mb-2">Ingredients:</label>


                                            <div x-data="{
                                                ingredients: @entangle('form.ingredients'),
                                                addNewIngredient() {
                                                    this.ingredients.push({
                                                        ingredientText: '',
                                                    });
                                                },
                                                removeIngredient(index) {
                                                    this.ingredients.splice(index, 1);
                                                }
                                            }">
                                                <template x-for="(ingredient, index) in ingredients"
                                                    :key="index">
                                                    <div>
                                                        <div x-text="index + 1"></div>
                                                        <textarea type="text" x-model="ingredient.ingredientText" name="ingredientText" class="form-control"></textarea>
                                                        <button type="button" class="btn btn-danger btn-small"
                                                            @click="removeIngredient(index)">Remove</button>
                                                    </div>
                                                </template>

                                                <button type="button" class="btn btn-info"
                                                    @click="addNewIngredient()">+ Add
                                                    Row</button>

                                                {{-- <textarea id="steps" wire:model="form.steps" rows="4" class="w-full border border-gray-300 px-4 py-2 rounded"></textarea> --}}


                                            </div>


                                            {{-- <input id="ingredients" wire:model="form.ingredients" rows="4"
                                                class="w-full border border-gray-300 px-4 py-2 rounded"> --}}
                                        </div>

                                        <div>
                                            <input type="file" wire:model="form.image">
                                            @error('form.image')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit"
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded mr-2">{{ $recipeId ? 'Update' : 'Create' }}</button>
                                            <button type="button"
                                                class="bg-rose-800 hover:bg-rose-900 text-white font-bold py-2 px-4 rounded"
                                                wire:click="closeModal">Cancel</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

use App\Livewire\Recipe;
use App\Livewire\RecipesListing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('recipes', [ViewController::class, 'showAllRecipes'])->name('recipes');

Route::get('recipes', [RecipesListing::class, 'allRecipes'])->name('recipes');


Route::get('my-recipes', [RecipesListing::class, 'userRecipes'])->name('my-recipes');

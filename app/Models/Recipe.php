<?php

namespace App\Models;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'ingredients', 'steps', 'image_path', 'is_public'
    ];
    public $timestamps = true;

    public function ingredient()
    {
        return $this->hasMany(Ingredient::class);
    }
}

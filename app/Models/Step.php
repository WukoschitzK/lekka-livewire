<?php

namespace App\Models;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'item'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

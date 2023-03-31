<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'image',
        'recipe',
    ];

    public function foods()
    {
        return $this->belongsToMany(Food::class)->withPivot('amount', 'seasoning');
    }
}

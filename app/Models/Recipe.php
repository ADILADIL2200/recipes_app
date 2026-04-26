<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'steps',
        'prep_time',
        'cook_time',
        'servings',
        'image',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function ratings()
{
    return $this->hasMany(Rating::class);
}
    




public function favorites()
{
    return $this->hasMany(Favorite::class);
}

public function isFavoritedBy(User $user): bool
{
    return $this->favorites()->where('user_id', $user->id)->exists();
}







}
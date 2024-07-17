<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

    protected $fillable = [
        'title_en', 'title_ar', 'name_en', 'name_ar', 
        'description_en', 'description_ar', 'model_en', 
        'model_ar', 'avatar_main', 'avatar_details', 
        'price_before_discount', 'price', 'quantity', 
        'stars', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

    protected $fillable = ['big_category_id', 'name_en', 'name_ar', 'avatar'];

    public function bigCategory()
    {
        return $this->belongsTo(BigCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

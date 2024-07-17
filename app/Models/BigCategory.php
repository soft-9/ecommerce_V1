<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigCategory extends Model
{
  use HasFactory;

  protected $fillable = ['name_en', 'name_ar', 'avatar'];

  public function categories()
  {
      return $this->hasMany(Category::class);
  }
}

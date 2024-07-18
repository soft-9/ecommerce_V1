<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en', 'title_ar', 'name_en', 'name_ar', 'description_en', 'description_ar',
        'model_en', 'model_ar', 'avatar_main', 'avatar_details', 'price_before_discount', 
        'price', 'quantity', 'stars', 'category_id', 'created_by', 'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function setAvatarDetailsAttribute($value)
    {
        $this->attributes['avatar_details'] = json_encode($value);
    }

    public function getAvatarDetailsAttribute($value)
    {
        return json_decode($value, true);
    }

    protected $casts = [
        'avatar_details' => 'array',
    ];

    public function getAvatarMainUrlAttribute()
    {
        return $this->avatar_main ? asset('storage/' . $this->avatar_main) : null;
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

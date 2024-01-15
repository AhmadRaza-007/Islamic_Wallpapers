<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'order',
    ];
    public function wallpapers(){
        return $this->hasMany(Wallpaper::class);
    }
    public function wallpapersLikesCount(){
        return $this->hasMany(Wallpaper::class)->withCount('likes');

//        return $this->wallpapers->likes->count();
    }
}

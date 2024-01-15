<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallpaper extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category_id',
        'wallpaper_image_url',
        'wallpaper_image'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function likes(){
        return $this->hasMany(WallpaperLike::class);
    }
    public function dislikes(){
        return $this->hasMany(WallpaperDislike::class);
    }
    public function favroutes(){
        return $this->hasMany(WallpaperDislike::class);
    }
      public function favrouteByUser($userId){
        return $this->hasMany(WallpaperFavourite::class)->whereUserId($userId);
    }
      public function likeByUser($userId){
        return $this->hasMany(WallpaperLike::class)->whereUserId($userId);
    }
}

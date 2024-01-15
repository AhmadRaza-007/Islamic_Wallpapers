<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WallpaperDislike extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'wallpaper_id',
    ];
    public function wallpaper(){
        return $this->belongsTo(Wallpaper::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

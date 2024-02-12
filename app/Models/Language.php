<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'language'
    ];

    /**
     * The verse that belong to the Language
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function verse()
    // {
    //     return $this->belongsToMany(Verse::class, 'verse_languages');
    // }

    public function verse()
    {
        return $this->hasMany(Verse::class);
    }
}

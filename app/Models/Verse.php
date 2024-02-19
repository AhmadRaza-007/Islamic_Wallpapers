<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory;

    protected $fillable = [
        'surah_id',
        'verse_number',
        'verse',
        'language_id',
        'startTime',
        'endTime',
    ];

    /**
     * The language that belong to the Verse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'verse_languages');
    }

    public function translate()
    {
        return $this->hasMany(Verse::class, 'id');
    }

    public function language()
    {
        return $this->hasOne(Language::class);
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class);
    }


}

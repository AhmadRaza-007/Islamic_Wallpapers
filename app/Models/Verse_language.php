<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse_language extends Model
{
    use HasFactory;

    protected $fillable = [
        'surah_id',
        'verse_id',
        'language_id',
    ];

    /**
     * Get all of the verse for the Verse_language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


}

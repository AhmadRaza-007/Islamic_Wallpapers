<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'surah_number',
        'surah',
    ];

    /**
     * Get all of the verse for the Surah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verse()
    {
        return $this->hasMany(Verse::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

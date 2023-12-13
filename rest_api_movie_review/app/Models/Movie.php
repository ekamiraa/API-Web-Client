<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamp = true;
    public $incrementing = true;

    protected $fillable = [
        'title',
        'genre',
        'actors',
        'sutradara',
        'image'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamp = true;
    public $incrementing = true;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'genre',
        'image'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}

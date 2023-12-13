<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reviewer extends Model
{
    protected $table = 'reviewers';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamp = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'email',
        // tambahkan properti lain yang perlu diisi secara massal
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'url',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

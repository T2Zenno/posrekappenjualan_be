<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'code',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'longitude',
        'latitude',
        'image',
        'beds',
        'rooms',
        'bathrooms',
        'square_meters',
        'is_visible'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class);
    }
}

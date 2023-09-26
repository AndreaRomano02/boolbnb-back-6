<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

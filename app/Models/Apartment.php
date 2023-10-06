<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'longitude',
        'latitude',
        'price',
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
        return $this->belongsToMany(Sponsor::class)->withPivot('start_date', 'end_date');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function images()
    {
        return $this->HasMany(Image::class);
    }
}

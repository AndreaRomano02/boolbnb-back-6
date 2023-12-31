<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['plan', 'price', 'duration'];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('start_date', 'end_date');
    }
}

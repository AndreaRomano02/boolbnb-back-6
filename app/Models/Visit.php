<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['apartment_id', 'IP_address', 'date'];

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
}

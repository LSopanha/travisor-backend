<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        "continent_name", 
        "profile_picture",
        "description",
        "active"
    ];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function destimations()
    {
        return $this->hasMany(Destination::class);
    }
}

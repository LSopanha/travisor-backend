<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        "country_name",
        "profile_picture",
        "description",
        "continent_id",
        "active"
    ];

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    public function destimations()
    {
        return $this->hasMany(Destination::class);
    }
}

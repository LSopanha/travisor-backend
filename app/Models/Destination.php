<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        "destination_name",	
        "description",	
        "profile_picture",	
        "continent_id",
        "country_id",	
        "active"    
    ];

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    public function country() 
    {
        return $this->belongsTo(Country::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

}

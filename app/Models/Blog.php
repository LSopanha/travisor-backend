<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        "user_id",	
        "destination_id",	
        "title",	
        "text",	
        "active"
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function destination() 
    {
        return $this->belongsTo(Destination::class);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}

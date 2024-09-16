<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [

    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }


    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}

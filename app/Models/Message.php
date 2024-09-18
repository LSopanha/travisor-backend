<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        "name",	
        "phone",
        "email",
        "message",	
        "active"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Fields allowed for mass assignment
    protected $fillable = [
        'user_id',
        'role',
        'content',
    ];
}

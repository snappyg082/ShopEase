<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = [
        'sms',
        'read',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

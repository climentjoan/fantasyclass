<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videochat extends Model
{
    protected $fillable = [
        'name',
        'active',
        'url',
        'classroom_id',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}

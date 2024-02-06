<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $casts = [
        'year' => 'integer',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}

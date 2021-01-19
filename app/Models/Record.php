<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'url', 'host', 'no_water_mark_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

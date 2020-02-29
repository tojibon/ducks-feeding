<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name'
    ];

    public function feedings()
    {
        return $this->hasMany(Feeding::class);
    }
}

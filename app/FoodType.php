<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function feedings()
    {
        return $this->hasMany(Feeding::class);
    }
}

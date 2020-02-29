<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'food_type_id',
        'name'
    ];

    public function food_type()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function feedings()
    {
        return $this->hasMany(Feeding::class);
    }
}

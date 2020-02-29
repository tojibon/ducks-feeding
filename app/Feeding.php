<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    protected $fillable = [
        'food_type_id',
        'food_id',
        'location_id',
        'total_ducks',
        'amount_foods',
        'feeding_time',
        'daily_recurring'
    ];

    protected $casts = [
        'daily_recurring' => 'boolean'
    ];

    public function scopeRecurring($query)
    {
        return $query->where('daily_recurring', '1')->whereRaw("DATE(CURDATE()) > DATE(feeding_time)");
    }

    public function food_type()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

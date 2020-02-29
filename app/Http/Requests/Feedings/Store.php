<?php

namespace App\Http\Requests\Feedings;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules()
    {
        return [
            'food_type_id' => 'required|exists:food_types,id',
            'food_id' => 'required|exists:foods,id',
            'location_id' => 'required|exists:locations,id',
            'total_ducks' => 'required|integer',
            'amount_foods' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'feeding_time' => 'required|date',
            'daily_recurring' => 'nullable|boolean',
        ];
    }
}

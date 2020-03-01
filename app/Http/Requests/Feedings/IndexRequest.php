<?php

namespace App\Http\Requests\Feedings;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'food_type_id' => 'nullable|exists:food_types,id',
            'food_id' => 'nullable|exists:foods,id',
            'location_id' => 'nullable|exists:locations,id',
            'display_all' => 'nullable',
        ];
    }
}

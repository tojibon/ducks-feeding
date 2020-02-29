<?php

namespace App\Http\Requests\Foods;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'food_type_id' => 'required|integer'
        ];
    }
}

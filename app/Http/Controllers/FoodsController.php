<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(Food::where('food_type_id', $request->get('food_type_id'))->get());
    }
}

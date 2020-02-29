<?php

namespace App\Http\Controllers;

use App\Feeding;
use App\Food;
use App\FoodType;
use App\Location;
use Illuminate\Http\Request;

class FeedingsController extends Controller
{
    public function index() {
        $records = Feeding::with(['food_type', 'food', 'location'])->whereRaw("DATE(CURDATE()) = DATE(feeding_time)")->get();

        return view('feedings.index', [
            'records' => $records
        ]);
    }

    public function create() {
        $locations = Location::all();
        $food_types = FoodType::all();
        $foods = Food::all();

        return view('feedings.new', [
            'locations' => $locations,
            'food_types' => $food_types,
            'foods' => $foods
        ]);
    }

    public function store(Request $request) {
        $properties = $request->all();
        $properties['feeding_time'] = date('Y-m-d H:i:s', strtotime($properties['feeding_time']));

        Feeding::create($properties);

        return (
        redirect()
            ->route('feedings.submit')
            ->with('success', 'Thank you, your submission has been sent successfully!')
        );
    }
}

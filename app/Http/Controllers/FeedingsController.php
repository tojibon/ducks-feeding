<?php

namespace App\Http\Controllers;

use App\Feeding;
use App\Http\Requests\Feedings\IndexRequest;
use App\Http\Requests\Feedings\Store;
use App\Http\Resources\FeedingResource;
use App\Http\Resources\FoodResource;
use App\Http\Resources\FoodTypeResource;
use App\Http\Resources\LocationResource;
use App\Repositories\Contracts\FeedingRepository;
use App\Repositories\Contracts\FoodRepository;
use App\Repositories\Contracts\FoodTypeRepository;
use App\Repositories\Contracts\LocationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orkhanahmadov\EloquentRepository\Repository\Eloquent\Criteria\EagerLoad;
use Orkhanahmadov\EloquentRepository\Repository\Eloquent\Criteria\OrderBy;
use Symfony\Component\Console\Input\Input;

class FeedingsController extends Controller
{
    /**
     * @var \App\Repositories\Eloquent\EloquentFoodTypeRepository|FoodTypeRepository $food_types
     */
    private $food_types;

    /**
     * @var \App\Repositories\Eloquent\EloquentFoodRepository|FoodRepository $foods
     */
    private $foods;

    /**
     * @var \App\Repositories\Eloquent\EloquentLocationRepository|LocationRepository $locations
     */
    private $locations;

    /**
     * @var \App\Repositories\Eloquent\EloquentFeedingRepository|FeedingRepository $feedings
     */
    private $feedings;

    /**
     * FeedingsController constructor.
     * @param \App\Repositories\Eloquent\EloquentFoodTypeRepository|FoodTypeRepository $food_types
     * @param \App\Repositories\Eloquent\EloquentFoodRepository|FoodRepository $foods
     * @param \App\Repositories\Eloquent\EloquentLocationRepository|LocationRepository $location
     * @param \App\Repositories\Eloquent\EloquentFeedingRepository|FeedingRepository $feedings
     */
    public function __construct(FoodTypeRepository $food_types, FoodRepository $foods, LocationRepository $locations, FeedingRepository $feedings)
    {
        $this->food_types = $food_types;
        $this->foods = $foods;
        $this->locations = $locations;
        $this->feedings = $feedings;
    }

    public function index(IndexRequest $request)
    {
        $locations = $this->locations->filter($request->all());
        $food_types = $this->food_types->filter($request->all());
        $foods = $this->foods->filter($request->all());

        $records = $this->feedings->withCriteria(
            new EagerLoad('food_type', 'food', 'location'),
            new OrderBy('created_at', 'desc')
        )->filter($request->validated());

        $graph_records = Feeding::select(DB::raw('sum(total_ducks) as total_ducks, sum(amount_foods) as amount_foods, DATE(feeding_time) day'));

        $properties = $request->validated();
        if (isset($properties['food_type_id'])) {
            $graph_records = $graph_records->where('food_type_id', $properties['food_type_id']);
        }

        if (isset($properties['food_id'])) {
            $graph_records = $graph_records->where('food_id', $properties['food_id']);
        }

        if (isset($properties['location_id'])) {
            $graph_records = $graph_records->where('location_id', $properties['location_id']);
        }

        if (empty($properties['display_all']) && !(!empty($properties['start_date']) && !empty($properties['end_date']))) {
            $graph_records = $graph_records->whereRaw("DATE(CURDATE()) = DATE(feeding_time)");
        }

        if (!empty($properties['start_date']) && !empty($properties['end_date'])) {
            $graph_records = $graph_records->whereBetween("feeding_time", [$properties['start_date'], $properties['end_date']]);
        }

        $graph_records = $graph_records->groupBy('day')->get();

        return view('feedings.index', [
            'records' => FeedingResource::collection($records),
            'locations' => LocationResource::collection($locations),
            'food_types' => FoodTypeResource::collection($food_types),
            'foods' => FoodResource::collection($foods),
            'graph_records' => $graph_records,
        ]);
    }

    public function create(Request $request)
    {
        $locations = $this->locations->filter($request->all());
        $food_types = $this->food_types->filter($request->all());
        $foods = $this->foods->filter($request->all());

        return view('feedings.new', [
            'locations' => LocationResource::collection($locations),
            'food_types' => FoodTypeResource::collection($food_types),
            'foods' => FoodResource::collection($foods)
        ]);
    }

    public function store(Store $request)
    {
        $properties = $request->all();
        $properties['feeding_time'] = date('Y-m-d H:i:s', strtotime($properties['feeding_time']));

        $this->feedings->create($properties);

        return (
        redirect()
            ->route('feedings.submit')
            ->with('success', 'Thank you, your submission has been sent successfully!')
        );
    }
}

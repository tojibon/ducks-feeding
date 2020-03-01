<?php

namespace App\Http\Controllers;

use App\Feeding;
use App\Food;
use App\FoodType;
use App\Http\Requests\Feedings\IndexRequest;
use App\Http\Requests\Feedings\Store;
use App\Http\Resources\FeedingResource;
use App\Location;
use App\Repositories\Contracts\FeedingRepository;
use Orkhanahmadov\EloquentRepository\Repository\Eloquent\Criteria\EagerLoad;
use Orkhanahmadov\EloquentRepository\Repository\Eloquent\Criteria\OrderBy;

class FeedingsController extends Controller
{
    /**
     * @var \App\Repositories\Eloquent\EloquentFeedingRepository|FeedingRepository $feedings
     */
    private $feedings;

    /**
     * FeedingsController constructor.
     * @param \App\Repositories\Eloquent\EloquentFeedingRepository|FeedingRepository $feedings
     */
    public function __construct(FeedingRepository $feedings)
    {
        $this->feedings = $feedings;
    }

    public function index(IndexRequest $request)
    {
        $records = $this->feedings->withCriteria(
            new EagerLoad('food_type', 'food', 'location'),
            new OrderBy('created_at', 'desc')
        )->filter($request->validated());

        return view('feedings.index', [
            'records' => FeedingResource::collection($records)
        ]);
    }

    public function create()
    {
        $locations = Location::all();
        $food_types = FoodType::all();
        $foods = Food::all();

        return view('feedings.new', [
            'locations' => $locations,
            'food_types' => $food_types,
            'foods' => $foods
        ]);
    }

    public function store(Store $request)
    {
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

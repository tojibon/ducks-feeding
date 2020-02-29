<?php

namespace App\Http\Controllers;

use App\Http\Requests\Foods\IndexRequest;
use App\Http\Resources\FoodResource;
use App\Repositories\Contracts\FoodRepository;
use Illuminate\Http\Response;
use Orkhanahmadov\EloquentRepository\Repository\Eloquent\Criteria\OrderBy;

class FoodsController extends Controller
{
    /**
     * @var \App\Repositories\Eloquent\EloquentFoodRepository|FoodRepository $foods
     */
    private $foods;

    /**
     * FoodsController constructor.
     * @param \App\Repositories\Eloquent\EloquentFoodRepository|FoodRepository $foods
     */
    public function __construct(FoodRepository $foods)
    {
        $this->foods = $foods;
    }

    public function __invoke(IndexRequest $request)
    {
        $foods = $this->foods->withCriteria(
            new OrderBy('name', 'asc')
        )->filter($request->validated());

        return response()->json(
            FoodResource::collection($foods),
            Response::HTTP_OK
        );
    }
}

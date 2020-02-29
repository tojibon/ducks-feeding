<?php

namespace App\Repositories\Eloquent;

use App\Food;
use App\Repositories\Contracts\FoodRepository;
use Orkhanahmadov\EloquentRepository\EloquentRepository;

class EloquentFoodRepository extends EloquentRepository implements FoodRepository
{
    protected function entity()
    {
        return Food::class;
    }

    public function filter($properties)
    {
        if (isset($properties['food_type_id'])) {
            $this->entity = $this->entity->where('food_type_id', $properties['food_type_id']);
        }
        if (isset($properties['name'])) {
            $this->entity = $this->entity->where("name", "LIKE", "%{$properties['name']}%");
        }
        return $this->entity->get();
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\FoodType;
use App\Repositories\Contracts\FoodTypeRepository;
use Orkhanahmadov\EloquentRepository\EloquentRepository;

class EloquentFoodTypeRepository extends EloquentRepository implements FoodTypeRepository
{
    protected function entity()
    {
        return FoodType::class;
    }

    public function filter($properties)
    {
        if (isset($properties['name'])) {
            $this->entity = $this->entity->where("name", "LIKE", "%{$properties['name']}%");
        }
        return $this->entity->get();
    }
}

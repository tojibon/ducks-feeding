<?php

namespace App\Repositories\Eloquent;

use App\Feeding;
use App\Repositories\Contracts\FeedingRepository;
use Orkhanahmadov\EloquentRepository\EloquentRepository;
use Symfony\Component\Console\Input\Input;

class EloquentFeedingRepository extends EloquentRepository implements FeedingRepository
{
    protected function entity()
    {
        return Feeding::class;
    }

    public function filter($properties)
    {
        if (isset($properties['food_type_id'])) {
            $this->entity = $this->entity->where('food_type_id', $properties['food_type_id']);
        }

        if (isset($properties['food_id'])) {
            $this->entity = $this->entity->where('food_id', $properties['food_id']);
        }

        if (empty($properties['display_all'])) {
            $this->entity = $this->entity->whereRaw("DATE(CURDATE()) = DATE(feeding_time)");
        }

        return $this->entity->paginate(10)->appends([
            'food_type_id' => !empty($properties['food_type_id']) ? $properties['food_type_id'] : '',
            'food_id' => !empty($properties['food_id']) ? $properties['food_id'] : '',
            'display_all'=>!empty($properties['display_all']) ? $properties['display_all'] : '',
        ]);
    }
}

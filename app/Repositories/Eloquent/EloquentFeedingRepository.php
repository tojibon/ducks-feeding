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

        if (isset($properties['location_id'])) {
            $this->entity = $this->entity->where('location_id', $properties['location_id']);
        }

        if (empty($properties['display_all']) && !(!empty($properties['start_date']) && !empty($properties['end_date']))) {
            $this->entity = $this->entity->whereRaw("DATE(CURDATE()) = DATE(feeding_time)");
        }

        if (!empty($properties['start_date']) && !empty($properties['end_date'])) {
            $this->entity = $this->entity->whereBetween("feeding_time", [$properties['start_date'], $properties['end_date']]);
        }

        return $this->entity->paginate(10)->appends([
            'start_date' => !empty($properties['start_date']) ? $properties['start_date'] : '',
            'end_date' => !empty($properties['end_date']) ? $properties['end_date'] : '',
            'food_type_id' => !empty($properties['food_type_id']) ? $properties['food_type_id'] : '',
            'food_id' => !empty($properties['food_id']) ? $properties['food_id'] : '',
            'location_id' => !empty($properties['location_id']) ? $properties['location_id'] : '',
            'display_all'=>!empty($properties['display_all']) ? $properties['display_all'] : '',
        ]);
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Location;
use App\Repositories\Contracts\LocationRepository;
use Orkhanahmadov\EloquentRepository\EloquentRepository;

class EloquentLocationRepository extends EloquentRepository implements LocationRepository
{
    protected function entity()
    {
        return Location::class;
    }

    public function filter($properties)
    {
        if (isset($properties['name'])) {
            $this->entity = $this->entity->where("name", "LIKE", "%{$properties['name']}%");
        }
        return $this->entity->get();
    }
}

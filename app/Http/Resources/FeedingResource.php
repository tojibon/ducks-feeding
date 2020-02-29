<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "food_type" => new FoodTypeResource($this->whenLoaded('food_type')),
            "food" => new FoodResource($this->whenLoaded('food')),
            "location" => new LocationResource($this->whenLoaded('location')),
            "total_ducks" => $this->total_ducks,
            "amount_foods" => $this->amount_foods,
            "feeding_time" => $this->feeding_time,
            "daily_recurring" => $this->daily_recurring,
        ];
    }
}

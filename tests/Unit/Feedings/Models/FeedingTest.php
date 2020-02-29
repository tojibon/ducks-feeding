<?php

namespace Tests\Unit\Feedings\Models;

use App\Feeding;
use App\Food;
use App\FoodType;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedingTest extends TestCase
{
    use RefreshDatabase;

    public function test_feeding_belongs_to_a_location()
    {
        $location = factory(Location::class)->create();
        $feeding = factory(Feeding::class)->create([
            'location_id' => $location->id
        ]);

        $this->assertInstanceOf(Location::class, $feeding->location);
        $this->assertEquals($location->id, $feeding->location->id);
    }

    public function test_feeding_belongs_to_a_food()
    {
        $food = factory(Food::class)->create();
        $feeding = factory(Feeding::class)->create([
            'food_id' => $food->id
        ]);

        $this->assertInstanceOf(Food::class, $feeding->food);
        $this->assertEquals($food->id, $feeding->food->id);
    }

    public function test_feeding_belongs_to_a_food_type()
    {
        $food_type = factory(FoodType::class)->create();
        $food = factory(Food::class)->create([
            'food_type_id' => $food_type->id
        ]);
        $feeding = factory(Feeding::class)->create([
            'food_id' => $food->id,
            'food_type_id' => $food->food_type_id
        ]);

        $this->assertInstanceOf(FoodType::class, $feeding->food_type);
        $this->assertInstanceOf(Food::class, $feeding->food);
        $this->assertEquals($food_type->id, $feeding->food_type->id);
        $this->assertEquals($food->id, $feeding->food->id);
    }

    public function testExample()
    {
        $this->assertTrue(true);
    }
}

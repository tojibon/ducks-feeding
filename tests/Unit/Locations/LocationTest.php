<?php

namespace Tests\Unit;

use App\Feeding;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_should_have_all_required_properties()
    {
        $location = factory(Location::class)->create();

        $this->assertInstanceOf(Location::class, $location);
        $this->assertNotEmpty($location->name);
    }

    public function test_feeding_has_many_feedings()
    {
        $location = factory(Location::class)->create();
        factory(Feeding::class, 2)->create([
            'location_id' => $location->id
        ]);

        $this->assertCount(2, $location->feedings);
        $this->assertInstanceOf(Feeding::class, $location->feedings->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}

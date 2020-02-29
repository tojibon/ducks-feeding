<?php

namespace Tests\Feature\Feedings;

use App\Feeding;
use App\Food;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class FeedingTest extends TestCase
{
    use RefreshDatabase;

    private $food;
    private $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->food = factory(Food::class)->create();
        $this->location = factory(Location::class)->create();
    }

    public function test_index_should_have_correct_contents()
    {
        factory(Feeding::class, 2)->create([
            'food_type_id' => $this->food->food_type_id,
            'food_id' => $this->food->id,
            'location_id' => $this->location->id,
            'feeding_time' => date('Y-m-d H:i:s'),
            'total_ducks' => 50
        ]);

        $response = $this->getJson('/feedings/overview');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText('Daily Feedings');
        $response->assertSeeText(50);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

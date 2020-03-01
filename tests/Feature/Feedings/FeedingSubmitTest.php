<?php

namespace Tests\Feature\Feedings;

use App\Food;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class FeedingSubmitTest extends TestCase
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

    public function test_store_should_have_create_correct_contents()
    {
        $feed = [
            'food_type_id' => $this->food->food_type_id,
            'food_id' => $this->food->id,
            'location_id' => $this->location->id,
            'feeding_time' => date('Y-m-d H:i:s'),
            'total_ducks' => 500,
            'amount_foods' => 50,
            'daily_recurring' => false,
        ];
        $response = $this->post(route('feedings.submit'), $feed);
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get('/feedings/overview?display_all=yes');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText('Daily Feedings');
        $response->assertSeeText(500);
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

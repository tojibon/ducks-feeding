<?php

namespace Tests\Feature\Foods;

use App\Food;
use App\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    private $food_type;

    protected function setUp(): void
    {
        parent::setUp();

        $this->food_type = factory(FoodType::class)->create();
    }

    public function test_index_should_returns_correct_collection()
    {
        factory(Food::class, 2)->create([
            'food_type_id' => $this->food_type->id
        ]);

        $response = $this->getJson('/foods?food_type_id=' . $this->food_type->id);

        $this->assertCount(2, $response->getData(true));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson($response->getData(true));
        $response->assertJsonStructure([
            '*' => [
                'id',
                'food_type_id',
                'name',
                'created_at',
                'updated_at',
            ]
        ]);
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

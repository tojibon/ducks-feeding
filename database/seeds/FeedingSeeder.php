<?php

use App\Feeding;
use Illuminate\Database\Seeder;

class FeedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Feeding::class, 500)->create();
    }
}

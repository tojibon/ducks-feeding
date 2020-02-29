<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFeedingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('food_type_id')->nullable();
            $table->foreign('food_type_id')->references('id')->on('food_types')->onDelete('set null');

            $table->unsignedBigInteger('food_id')->nullable();
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('set null');

            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');

            $table->integer('total_ducks')->default(0);
            $table->float('amount_foods')->default(0);
            $table->dateTime('feeding_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('daily_recurring')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedings');
    }
}

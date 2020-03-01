<?php

namespace App\Providers;

use App\Repositories\Contracts\FeedingRepository;
use App\Repositories\Contracts\FoodRepository;
use App\Repositories\Contracts\FoodTypeRepository;
use App\Repositories\Contracts\LocationRepository;
use App\Repositories\Eloquent\EloquentFeedingRepository;
use App\Repositories\Eloquent\EloquentFoodRepository;
use App\Repositories\Eloquent\EloquentFoodTypeRepository;
use App\Repositories\Eloquent\EloquentLocationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(FoodTypeRepository::class, EloquentFoodTypeRepository::class);
        $this->app->bind(FoodRepository::class, EloquentFoodRepository::class);
        $this->app->bind(LocationRepository::class, EloquentLocationRepository::class);
        $this->app->bind(FeedingRepository::class, EloquentFeedingRepository::class);
    }
}

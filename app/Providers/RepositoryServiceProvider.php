<?php

namespace App\Providers;

use App\Repositories\Contracts\FeedingRepository;
use App\Repositories\Contracts\FoodRepository;
use App\Repositories\Eloquent\EloquentFeedingRepository;
use App\Repositories\Eloquent\EloquentFoodRepository;
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
        $this->app->bind(FoodRepository::class, EloquentFoodRepository::class);
        $this->app->bind(FeedingRepository::class, EloquentFeedingRepository::class);
    }
}

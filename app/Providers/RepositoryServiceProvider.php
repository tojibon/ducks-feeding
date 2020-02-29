<?php

namespace App\Providers;

use App\Repositories\Contracts\FoodRepository;
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
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\SolarPanel\ISolarPanelRepository;
use App\Repositories\SolarPanel\SolarPanelRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(ISolarPanelRepository::class, SolarPanelRepository::class);


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

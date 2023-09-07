<?php

namespace App\Providers;

use App\Repositories\DashboardInterface;
use App\Repositories\OrderInterface;
use App\Repositories\Repository\DashboardRepository;
use App\Repositories\Repository\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DashboardInterface::class, DashboardRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
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

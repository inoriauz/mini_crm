<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $this->app->bind(OrderInterface::class, OrderRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Order::observe(OrderObserver::class);

    }
}

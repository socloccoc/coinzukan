<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\PairRepositoryInterface',
            'App\Repositories\Eloquents\PairRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\MarketsRepositoryInterface',
            'App\Repositories\Eloquents\MarketsRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CoinMarketCapRepositoryInterface',
            'App\Repositories\Eloquents\CoinMarketCapRepository'
        );
    }
}

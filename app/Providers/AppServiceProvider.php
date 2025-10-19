<?php

namespace App\Providers;
use App\Support\InclusiveCart;
use App\Models\Category;
use Illuminate\Support\Facades\View;

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
        // //
            $this->app->singleton('cart', function ($app) {
                return new InclusiveCart(
                    $app['session'],
                    $app['events']
                );
            });
    }


    

    

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
         View::composer('*', function ($view) {
        $view->with('categories', Category::all());
    });

    }

    
}

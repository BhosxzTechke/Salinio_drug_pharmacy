<?php

namespace App\Providers;
use App\Support\InclusiveCart;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;


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
    // Force HTTPS for all URLs in production
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

        // Disable ONLY_FULL_GROUP_BY in SQL mode
    DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

    // Share categories with all views
    View::composer('*', function ($view) {
        $view->with('categories', Category::all());
    });

    }

    
}

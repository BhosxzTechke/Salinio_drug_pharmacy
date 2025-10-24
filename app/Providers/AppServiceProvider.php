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

            // Disable ONLY_FULL_GROUP_BY only when DB is available
            try {
                DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            } catch (\Exception $e) {
                info("Skipping SQL mode change: " . $e->getMessage());
            }


            // Share categories safely
            View::composer('*', function ($view) {
                try {
                    $categories = cache()->rememberForever('categories', fn() => \App\Models\Category::all());
                    $view->with('categories', $categories);
                } catch (\Exception $e) {
                    $view->with('categories', collect());
                }
            });

    }

    
}

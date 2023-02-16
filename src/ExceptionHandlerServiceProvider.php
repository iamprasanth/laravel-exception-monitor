<?php

namespace Spt\ExceptionHandling;

use Illuminate\Support\ServiceProvider;

class ExceptionHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('exception', function ($app) {
            return new ExceptionHandling;
        });
        
        $this->mergeConfigFrom(
            __DIR__.'/config/sptexception.php',
            'sptexception'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // loading the routes file
        require __DIR__ . '/Http/routes.php';

        // define path of view file
        $this->loadViewsFrom(base_path('/resources/views/spt-views'), 'exceptions');

        $this->loadTranslationsFrom(base_path('/resources/lang/en/spt.php'), 'spt');

        // publish the view file
        $this->publishes([
            __DIR__ . '/../spt-views' => base_path('/resources/views/spt-views'),
        ]);

        // publish the css files
        $this->publishes([
            __DIR__ . '/../assets/css' => public_path('/css/spt-css'),
        ]);

        // publish the js files
        $this->publishes([
            __DIR__ . '/../assets/js' => public_path('/js/spt-js'),
        ]);

        //publish config
        $this->publishes([
            __DIR__.'/config/sptexception.php' => config_path('sptexception.php'),
        ], 'config');

        //publish translations
        $this->publishes([
            __DIR__.'/../translations/en/spt.php' => base_path('/resources/lang/en/spt.php'),
        ], 'config');
    }
}

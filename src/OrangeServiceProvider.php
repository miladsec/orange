<?php

namespace MiladZamir\Orange;

use Illuminate\Support\ServiceProvider;

class OrangeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/orange.php' => config_path('orange.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton(Orange::class, function () {
            return new Orange();
        });
    }
}

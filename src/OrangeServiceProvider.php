<?php

namespace MiladZamir\Orange;

use Illuminate\Support\ServiceProvider;

class OrangeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/orange.php' => config_path('orange.php'),
                __DIR__ . '/../database/migrations/create_oranges_table.php.stub' => database_path('migrations/' . '2020_10_30_064244_create_oranges_table.php')
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton(Orange::class, function () {
            return new Orange();
        });
    }
}

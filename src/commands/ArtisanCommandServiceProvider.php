<?php

namespace Brian\Commands;

use Brian\Commands\CreateRepository;
use Brian\Commands\CreateTrait;
use Brian\Commands\CreateService;
use Illuminate\Support\ServiceProvider;

class ArtisanCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRepository::class,
            ]);
            $this->commands([
                CreateTrait::class,
            ]);
            $this->commands([
                CreateService::class,
            ]);
        }
    }
}
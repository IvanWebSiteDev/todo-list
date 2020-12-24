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
        $this->registerTaskRepo();
    }

    public function registerTaskRepo()
    {
        return $this->app->bind(
            'App\Repositories\TaskRepositoryInterface',
            'App\Repositories\TaskRepository'
        );
    }
}

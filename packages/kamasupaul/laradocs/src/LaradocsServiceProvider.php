<?php

namespace Kamasupaul\Laradocs;

use Illuminate\Support\ServiceProvider;

class LaradocsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
            // register our controller
    $this->app->make('Kamasupaul\Laradocs\DocsController');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }
}

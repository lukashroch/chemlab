<?php

namespace ChemLab\Providers;

use ChemLab\Helpers\Helper;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelper();

        $this->app->alias('helper', 'ChemLab\Helpers\Helper');
    }

    /**
     * Register the Helper instance.
     *
     * @return void
     */
    protected function registerHelper()
    {
        $this->app->singleton('helper', function ($app) {
            return new Helper($app['url'], $app['view']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['helper', 'ChemLab\Helpers\Helper'];
    }
}

<?php

namespace Multicoin\Api;

use Illuminate\Support\ServiceProvider;

class MulticoinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/multicoin.php' => config_path('multicoin.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__.'/../config/multicoin.php', 'multicoin');

            /*  $this->publishes([
                __DIR__.'/../src/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->loadViewsFrom(__DIR__.'/../resources/views', 'multicoin');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/multicoin'),
            ], 'views');

             $this->loadRoutesFrom(__DIR__.'/routes.php');

              $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
            */
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerAliases();

        $this->registerFactory();
        $this->registerClient();

    }

    /**
     * Register aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            'multicoin'          => 'Multicoin\Api\multicoinFactory',
            'multicoin.currency' => 'Multicoin\Api\multicoin',
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->app->alias($key, $alias);
            }

        }

    }

    /**
     * Register client factory.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('multicoin', function ($app) {
            return new MulticoinFactory(config('multicoin'));
        });
        /*  $this->app->singleton('blockbook', function ($app) {
            return new BlockbookFactory(config('blockbook'), $app['log']);
        });*/
    }

    /**
     * Register client shortcut.
     *
     * @return void
     */
    protected function registerClient()
    {
        $this->app->bind('multicoin.currency', function ($app) {
            return $app['multicoin']->currency();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Multicoin::class];
    }

}

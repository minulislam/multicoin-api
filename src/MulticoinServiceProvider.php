<?php

namespace Multicoin\Api;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MulticoinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerPublishing();
        $this->registerRoutes();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/multicoin.php', 'multicoin');

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

    private function registerRoutes()
    {
        Route::macro('multicoinWebhook', function ($url) {
            return Route::any($url, '\Multicoin\Api\Http\Controllers\WebhookController');
        });
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/multicoin.php' => config_path('multicoin.php'),
            ], 'config');
        }
    }
}

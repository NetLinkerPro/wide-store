<?php

namespace NetLinker\WideStore;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use NetLinker\WideStore\Boot\ConnectionDatabaseCreator;

class WideStoreServiceProvider extends ServiceProvider
{

    use EventMap;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEvents();

        $this->registerDisk();

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wide-store');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wide-store');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }


    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wide-store.php', 'wide-store');

        // Register the service the package provides.
        $this->app->singleton('wide-store', function ($app) {
            return new WideStore();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wide-store'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {

        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/wide-store.php' => config_path('wide-store.php'),
        ], 'config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/wide-store'),
        ], 'views');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/wide-store'),
        ], 'views');

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wide-store'),
        ], 'views');

        // Registering package commands.
        $this->commands([]);
    }

    /**
     * Register the Horizon job events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register disk
     */
    private function registerDisk()
    {
        Config::set('filesystems.disks.wide_store',config('wide-store.disk'));
    }

}

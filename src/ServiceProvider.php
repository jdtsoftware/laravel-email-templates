<?php

namespace JDT\LaravelEmailTemplates;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerViews();
        $this->registerConfig();
        $this->registerMigrations();
    }

    /**
     * Register view paths.
     */
    public function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-email-templates');

        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/laravel-email-templates'),
        ]);
    }

    /**
     * Register config paths.
     */
    public function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-email-templates.php' => config_path('laravel-email-templates.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-email-templates.php',
            'laravel-email-templates'
        );
    }

    /**
     * Register migrations.
     */
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-email-templates', function ($app) {
            return new EmailTemplates(new EmailTemplateRepository());
        });
    }
}

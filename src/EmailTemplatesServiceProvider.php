<?php
namespace JDT\LaravelEmailTemplates;

use Illuminate\Support\ServiceProvider;

class EmailTemplatesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'../views', 'laravel-email-templates');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-email-templates', function ($app) {
            return new EmailTemplates();
        });
    }
}
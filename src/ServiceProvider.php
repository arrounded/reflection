<?php
namespace Arrounded\Reflection;

/**
 * Register the ArroundedServiceProvider classes.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Reflector::class, Reflector::class);
        $this->app->alias(Reflector::class, 'arrounded.reflector');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['arrounded.reflector'];
    }
}

<?php

namespace Presentit\Laravel;

use Presentit\Present;
use Illuminate\Support\ServiceProvider;
use Presentit\Transformer\TransformerFactoryInterface;

class PresentitServiceProvider extends ServiceProvider
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
        $this->app->singleton(TransformerFactoryInterface::class, function ($app) {
            return new TransformerFactory($app);
        });

        Present::setTransformerFactory($this->app[TransformerFactoryInterface::class]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            TransformerFactoryInterface::class,
        ];
    }
}

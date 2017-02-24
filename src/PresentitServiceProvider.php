<?php

namespace Presentit\Laravel;

use Presentit\Present;
use Illuminate\Support\Collection;
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
     * Boot the presentit service.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('present', function () {
            return Present::collection($this);
        });

        Collection::macro('transformWith', function ($transformer) {
            return $this->present()->with($transformer);
        });
    }

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

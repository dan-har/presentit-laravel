<?php

namespace Presentit\Laravel;

use Presentit\Present;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Presentit\Transformer\TransformerFactoryInterface;

class PresentitServiceProvider extends ServiceProvider
{
    /**
     * Boot the presentit service.
     *
     * @return void
     */
    public function boot()
    {
        $this->setPresentCollectionMacros();
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
     * Set presentit functionality to the base collection.
     */
    protected function setPresentCollectionMacros()
    {
        Collection::macro('present', function () {
            return Present::collection($this);
        });

        Collection::macro('transformWith', function ($transformer) {
            return $this->present()->with($transformer);
        });
    }
}

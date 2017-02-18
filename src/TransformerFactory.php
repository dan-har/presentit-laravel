<?php

namespace Presentit\Laravel;

use Illuminate\Contracts\Container\Container;
use Presentit\Transformer\TransformerFactory as BaseTransformerFactory;

class TransformerFactory extends BaseTransformerFactory
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * TransformerFactory constructor.
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a transformer from a class name.
     *
     * @param string $transformer
     * @return mixed
     */
     public function makeTransformerClass($transformer)
    {
        return $this->container->make($transformer);
    }
}

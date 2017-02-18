<?php

namespace Presentit\Laravel\Test;

use Mockery as m;
use Presentit\Laravel\TransformerFactory;
use Illuminate\Contracts\Container\Container;
use Presentit\Laravel\Test\Stubs\TransformerStub;

class TransformerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown() {
        m::close();
    }

    public function testFactoryCallContainerMakeFunction()
    {
        $container = m::mock(Container::class);
        $factory = new TransformerFactory($container);

        $container->shouldReceive('make')->once();

        $factory->make(TransformerStub::class);
    }
}

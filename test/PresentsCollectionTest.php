<?php

namespace Presentit\Laravel\Test;

use Mockery as m;
use Presentit\Present;
use Presentit\Presentation;
use Illuminate\Support\Collection;
use Presentit\Laravel\PresentitServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Presentit\Laravel\Test\Stubs\TransformerStub;

class PresentsCollectionTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $application = m::mock(Application::class);
        $provider = new PresentitServiceProvider($application);
        $provider->boot();
    }

    public static function tearDownBeforeClass()
    {
        m::close();
    }

    public function testPresentFunctionReturnPresentObject()
    {
        $entity = new Collection();

        $present = $entity->present();

        $this->assertInstanceOf(Present::class, $present);

        $this->assertEquals($present->getResource()->get(), $entity);
    }

    public function testTransformFunctionReturnsPresentation()
    {
        $entity = new Collection();

        $this->assertInstanceOf(Presentation::class, $entity->transformWith(new TransformerStub()));
    }
}

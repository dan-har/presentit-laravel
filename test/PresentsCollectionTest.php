<?php

namespace Presentit\Laravel\Test;

use Presentit\Present;
use Presentit\Presentation;
use Presentit\Laravel\Test\Stubs\TransformerStub;
use Presentit\Laravel\Test\Stubs\PresentsCollectionStub;

class PresentsCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testPresentFunctionReturnPresentObject()
    {
        $entity = new PresentsCollectionStub();

        $present = $entity->present();

        $this->assertInstanceOf(Present::class, $present);

        $this->assertEquals($present->getResource()->get(), $entity);
    }

    public function testTransformFunctionReturnsPresentation()
    {
        $entity = new PresentsCollectionStub();

        $this->assertInstanceOf(Presentation::class, $entity->transform(new TransformerStub()));
    }
}

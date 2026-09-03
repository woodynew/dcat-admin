<?php

namespace Tests\Feature;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Grid\Displayers\Modal;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class LazyRenderableCompatibilityTest extends TestCase
{
    public function testModalAcceptsContractWithoutPayloadMethod()
    {
        $renderable = new class implements LazyRenderable {
            public function getUrl()
            {
                return '/renderable';
            }

            public function render()
            {
                return 'content';
            }
        };
        $modal = (new ReflectionClass(Modal::class))->newInstanceWithoutConstructor();
        $method = new ReflectionMethod(Modal::class, 'setUpLazyRenderable');
        $method->setAccessible(true);

        $clone = $method->invoke($modal, $renderable);

        $this->assertNotSame($renderable, $clone);
        $this->assertSame('content', $clone->render());
    }
}

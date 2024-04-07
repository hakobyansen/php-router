<?php

namespace Unit\Routing;

use PhpRouter\Router\Route;
use Tests\TestCase;

final class RouteTest extends TestCase
{
    public function testValidateMethod(): void
    {
        $allowedMethods = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($allowedMethods as $method)
        {
            $this->expectNotToPerformAssertions();

            new Route(
                method: $method,
                endpoint: '/dummy'
            );
        }
    }

    public function testValidateMethodException(): void
    {
        $this->expectException('Exception');

        new Route(
            method: 'dummy',
            endpoint: '/dummy'
        );
    }
}
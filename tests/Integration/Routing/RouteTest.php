<?php

namespace Integration\Routing;

use PhpRouter\Router\Route;
use PhpRouter\Router\RouterHandler;
use Tests\TestCase;

final class RouteTest extends TestCase
{
    public function setUp(): void
    {
        RouterHandler::register();
    }

    public function testValidateEndpoint(): void
    {
        $this->expectNotToPerformAssertions();

        new Route(
            method: 'get',
            endpoint: '/test'
        );
    }

    public function testValidateMethodException(): void
    {
        $this->expectException(\Exception::class);

        new Route(
            method: 'dummy',
            endpoint: '/test'
        );
    }
}
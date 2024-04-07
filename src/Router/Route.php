<?php

namespace PhpRouter\Router;

#[Attribute]
final readonly class Route
{
    public function __construct(
        private string $method,
        private string $endpoint,
    )
    {
        self::validateMethod();
        self::validateEndpoint();
    }

    public function validateMethod(): void
    {
        $method = strtolower($this->method);

        $allowedMethods = ['get', 'post', 'put', 'patch', 'delete'];

        if(!in_array($method, $allowedMethods)) {
            throw new \Exception("Method {$method} not allowed");
        }
    }

    public function validateEndpoint(): void
    {
        $endpoint = strtolower($this->endpoint);

        $routes = RouterHandler::getRegisteredRoutes();

        foreach ($routes as $route) {
            if($route['endpoint'] === $endpoint) {
                throw new \Exception("Endopint {$endpoint} is already registered");
            }
        }
    }
}
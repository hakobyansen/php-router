<?php

namespace PhpRouter\Router;

readonly abstract class RouterBase
{
    abstract public function index(): array;

    protected function response(
        string $message = '',
        array $data = [],
        int $httpStatusCode = 200
    ): array
    {
        http_response_code($httpStatusCode);

        return [
            'message' => $message,
            'data' => $data
        ];
    }
}
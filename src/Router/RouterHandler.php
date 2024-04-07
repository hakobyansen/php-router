<?php

namespace PhpRouter\Router;

use App\Helpers\FileSystemUtil;

class RouterHandler
{
    private static array $registeredRoutes = [];

    private static string $routesDir = __DIR__ . '/Routes';

    public static function handle(): void
    {
        self::register();

        $uri = isset($_SERVER['REDIRECT_URL']) ? strtolower($_SERVER['REDIRECT_URL']) : '/';
        $method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');

        $executableRoute = null;

        foreach (self::getRegisteredRoutes() as $route)
        {
            if($route['endpoint'] === $uri && $route['method'] === $method) {
                $executableRoute = $route;
                break;
            }
        }

        if(!$executableRoute) {
            http_response_code(404);
            return;
        }

        $executable = new $executableRoute['executable'];

        echo json_encode($executable->index());
    }

    public static function register(): void
    {
        $routeFiles = FileSystemUtil::getFilesFromFolder(self::$routesDir);

        foreach ($routeFiles as $file)
        {
            $explode = explode('app/', $file);
            $class = 'App\\' . str_replace('/', '\\', ltrim($explode[1], '/'));
            $class = explode('.', $class)[0];

            $reflection = new \ReflectionClass($class);

            if ($reflection->isAbstract()) {
                continue;
            }

            $attributes = $reflection->getMethod('index')->getAttributes(Route::class);

            foreach ($attributes as $attribute)
            {
                $arguments = $attribute->getArguments();

                self::$registeredRoutes[] = [
                    'method' => $arguments['method'],
                    'endpoint' => $arguments['endpoint'],
                    'executable' => $class,
                ];
            }
        }
    }

    public static function getRegisteredRoutes(): array
    {
        return self::$registeredRoutes;
    }
}
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

class ApiDocsController
{
    public function __construct(private readonly Router $router) {}

    public function index(): View
    {
        $apiRoutes = collect($this->router->getRoutes())
            ->filter(function ($route): bool {
                /** @var \Illuminate\Routing\Route $route */
                $uri = $route->uri();

                return str_starts_with($uri, 'api/');
            })
            ->map(function ($route): array {
                /** @var \Illuminate\Routing\Route $route */
                return [
                    'methods' => collect($route->methods())
                        ->reject(fn (string $m) => $m === 'HEAD')
                        ->values()
                        ->all(),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'middleware' => $route->gatherMiddleware(),
                ];
            })
            ->sortBy('uri')
            ->values()
            ->all();

        return view('api-documentation', [
            'apiRoutes' => $apiRoutes,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use BombenProdukt\JsonApi\Http\Controller\ResourceController;
use BombenProdukt\JsonApi\Server\ServerInterface;
use Closure;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Str;

final class ResourceRegistrar
{
    public function __construct(
        private readonly Registrar $router,
        private readonly ServerInterface $server,
    ) {
        //
    }

    public function resource(string $resourceType, ?string $controller = null): PendingResourceRegistration
    {
        return new PendingResourceRegistration(
            $this,
            $resourceType,
            $controller ?? ResourceController::class,
        );
    }

    public function register(string $resourceType, string $controller): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($this->getResourceMethods() as $method) {
            $fn = 'register'.\ucfirst($method);
            $route = $this->{$fn}($resourceType, $controller);
            $routes->add($route);
        }

        return $routes;
    }

    public function registerRelationships(
        string $resourceType,
        string $controller,
        Closure $callback,
    ): RouteCollection {
        $registrar = new RelationshipRegistrar(
            $this->router,
            $this->server,
            $resourceType,
            Str::singular($resourceType),
            $controller,
            $parameter = $this->getResourceParameterName($resourceType),
        );

        $routes = new RouteCollection();

        $this->router->group(
            [
                'prefix' => \sprintf('%s/{%s}', $resourceType, $parameter),
                'as' => "{$resourceType}.",
            ],
            function () use ($registrar, $callback, $routes): void {
                $relationships = new Relationships($registrar);

                $callback($relationships, $this->router);

                foreach ($relationships->register() as $route) {
                    $routes->add($route);
                }
            },
        );

        return $routes;
    }

    protected function registerIndex(string $resourceType, string $controller): Route
    {
        return $this->attachListDefaults(
            $this->router->get(
                $resourceType,
                [
                    'as' => "{$resourceType}.index",
                    'uses' => "{$controller}@index",
                ],
            ),
            $resourceType,
        );
    }

    protected function registerStore(string $resourceType, string $controller): Route
    {
        return $this->attachListDefaults(
            $this->router->post(
                $resourceType,
                [
                    'as' => "{$resourceType}.store",
                    'uses' => "{$controller}@store",
                ],
            ),
            $resourceType,
        );
    }

    protected function registerShow(string $resourceType, string $controller): Route
    {
        return $this->attachResourceDefaults(
            $this->router->get(
                \sprintf('%s/{%s}', $resourceType, $this->getResourceParameterName($resourceType)),
                [
                    'as' => "{$resourceType}.show",
                    'uses' => "{$controller}@show",
                ],
            ),
            $resourceType,
        );
    }

    protected function registerUpdate(string $resourceType, string $controller): Route
    {
        return $this->attachResourceDefaults(
            $this->router->patch(
                \sprintf('%s/{%s}', $resourceType, $this->getResourceParameterName($resourceType)),
                [
                    'as' => "{$resourceType}.update",
                    'uses' => "{$controller}@update",
                ],
            ),
            $resourceType,
        );
    }

    protected function registerDestroy(string $resourceType, string $controller): Route
    {
        return $this->attachResourceDefaults(
            $this->router->delete(
                \sprintf('%s/{%s}', $resourceType, $this->getResourceParameterName($resourceType)),
                [
                    'as' => "{$resourceType}.destroy",
                    'uses' => "{$controller}@destroy",
                ],
            ),
            $resourceType,
        );
    }

    private function attachListDefaults(Route $route, string $resourceType): Route
    {
        $route->defaults(RouteParameter::API_VERSION, $this->server->getVersion());
        $route->defaults(RouteParameter::RESOURCE_TYPE, $resourceType);

        return $route;
    }

    private function attachResourceDefaults(Route $route, string $resourceType): Route
    {
        $route->defaults(RouteParameter::API_VERSION, $this->server->getVersion());
        $route->defaults(RouteParameter::RESOURCE_TYPE, $resourceType);
        $route->defaults(RouteParameter::RESOURCE_NAME, $this->getResourceParameterName($resourceType));

        return $route;
    }

    private function getResourceParameterName(string $resourceType): string
    {
        return Str::of($resourceType)
            ->singular()
            ->snake()
            ->toString();
    }

    private function getResourceMethods(): array
    {
        return ['index', 'store', 'show', 'update', 'destroy'];
    }
}

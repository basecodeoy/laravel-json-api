<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use BombenProdukt\JsonApi\Server\ServerInterface;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;

final class RelationshipRegistrar
{
    public function __construct(
        private readonly Registrar $router,
        private readonly ServerInterface $server,
        private readonly string $resourceType,
        private readonly string $resourceName,
        private readonly string $resourceRelationship,
    ) {
        //
    }

    public function register(string $relationship, string $controller, bool $hasMany): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($this->getResourceMethods() as $method) {
            $fn = 'register'.\ucfirst($method);
            $route = $this->{$fn}($relationship, $controller, $hasMany);
            $routes->add($route);
        }

        return $routes;
    }

    protected function registerIndex(string $relationship, string $controller): Route
    {
        return $this->attachDefaults(
            $this->router->get(
                $relationship,
                [
                    'as' => $relationship,
                    'uses' => "{$controller}@index",
                ],
            ),
            $relationship,
        );
    }

    protected function registerStore(string $relationship, string $controller): Route
    {
        return $this->attachDefaults(
            $this->router->post(
                "relationships/{$relationship}",
                [
                    'as' => "{$relationship}.store",
                    'uses' => "{$controller}@store",
                ],
            ),
            $relationship,
        );
    }

    protected function registerShow(string $relationship, string $controller): Route
    {
        return $this->attachDefaults(
            $this->router->get(
                "relationships/{$relationship}",
                [
                    'as' => "{$relationship}.index",
                    'uses' => "{$controller}@index",
                ],
            ),
            $relationship,
        );
    }

    protected function registerUpdate(string $relationship, string $controller): Route
    {
        return $this->attachDefaults(
            $this->router->patch(
                "relationships/{$relationship}",
                [
                    'as' => "{$relationship}.update",
                    'uses' => "{$controller}@update",
                ],
            ),
            $relationship,
        );
    }

    protected function registerDestroy(string $relationship, string $controller): Route
    {
        return $this->attachDefaults(
            $this->router->delete(
                "relationships/{$relationship}",
                [
                    'as' => "{$relationship}.destroy",
                    'uses' => "{$controller}@destroy",
                ],
            ),
            $relationship,
        );
    }

    private function attachDefaults(Route $route, string $relationship): Route
    {
        $route->defaults(RouteParameter::API_VERSION, $this->server->getVersion());
        $route->defaults(RouteParameter::RESOURCE_TYPE, $this->resourceType);
        $route->defaults(RouteParameter::RESOURCE_NAME, $this->resourceName);
        $route->defaults(RouteParameter::RESOURCE_RELATIONSHIP, $relationship);

        return $route;
    }

    private function getResourceMethods(): array
    {
        return ['index', 'store', 'show', 'update', 'destroy'];
    }
}

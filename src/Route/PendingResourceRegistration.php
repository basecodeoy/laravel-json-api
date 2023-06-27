<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use Closure;
use Illuminate\Routing\RouteCollection;

final class PendingResourceRegistration
{
    protected $registered = false;

    private ?Closure $relationships = null;

    public function __construct(
        private readonly ResourceRegistrar $registrar,
        private readonly string $resourceType,
        private readonly string $controller,
    ) {
        //
    }

    public function __destruct()
    {
        if (!$this->registered) {
            $this->register();
        }
    }

    public function relationships(Closure $callback): self
    {
        $this->relationships = $callback;

        return $this;
    }

    public function register(): RouteCollection
    {
        $this->registered = true;

        $routes = $this->registrar->register(
            $this->resourceType,
            $this->controller,
        );

        if ($this->relationships !== null) {
            $relations = $this->registrar->registerRelationships(
                $this->resourceType,
                $this->controller,
                $this->relationships,
            );

            foreach ($relations as $route) {
                $routes->add($route);
            }
        }

        return $routes;
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use BombenProdukt\JsonApi\Server\Server;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route as Illuminate;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin Illuminate
 */
final class Route implements RouterInterface
{
    use ForwardsCalls;

    public function __construct(private readonly Illuminate $route)
    {
        //
    }

    public function __call($name, $arguments)
    {
        return $this->forwardCallTo($this->route, $name, $arguments);
    }

    public function getApiVersion(): string
    {
        return $this->route->parameter(RouteParameter::API_VERSION);
    }

    public function getResourceType(): string
    {
        return $this->route->parameter(RouteParameter::RESOURCE_TYPE);
    }

    public function getResourceName(): ?string
    {
        return $this->route->parameter(RouteParameter::RESOURCE_NAME);
    }

    public function hasResourceName(): bool
    {
        return !empty($this->getResourceName());
    }

    public function getResourceRelationship(): ?string
    {
        return $this->route->parameter(RouteParameter::RESOURCE_RELATIONSHIP);
    }

    public function hasResourceRelationship(): bool
    {
        return !empty($this->getResourceRelationship());
    }

    public function getModel(): Model
    {
        return $this->route->parameter($this->getResourceName());
    }

    public function substituteBindings(): void
    {
        $resourceName = $this->getResourceName();

        if ($resourceName !== null) {
            /**
             * @var class-string<Model>
             */
            $modelClass = Server::getEntityRepository()->findByResourceType($this->getResourceType())->getModel();

            if ($this->route->parameter($resourceName) instanceof $modelClass) {
                return;
            }

            $this->route->setParameter(
                $resourceName,
                $modelClass::findOrFail($this->route->parameter($resourceName)),
            );
        }
    }
}

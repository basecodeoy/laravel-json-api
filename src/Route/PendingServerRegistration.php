<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Route;

use BombenProdukt\JsonApi\Http\Middleware\BootJsonApiMiddleware;
use BombenProdukt\JsonApi\Server\ServerInterface;
use Closure;
use Illuminate\Contracts\Routing\Registrar;

final class PendingServerRegistration
{
    private array $attributes;

    public function __construct(
        private readonly Registrar $router,
        private readonly ServerInterface $server,
    ) {
        $this->attributes = [
            'prefix' => $server->getVersion(),
            'as' => \sprintf('api.%s.', $server->getVersion()),
            'middleware' => BootJsonApiMiddleware::class,
        ];
    }

    public function resources(Closure $callback): void
    {
        $resourceRegistrar = $this->getResourceRegistrar();

        $this->router->group(
            $this->attributes,
            fn (): int => $callback($resourceRegistrar, $this->router),
        );
    }

    public function discover(): static
    {
        $resourceRegistrar = $this->getResourceRegistrar();

        $this->router->group($this->attributes, function () use ($resourceRegistrar): void {
            foreach ($this->server->getEntityRepository()->all() as $entity) {
                $resourceRegistrar
                    ->resource($entity->getResourceType())
                    ->relationships(function (Relationships $relationships) use ($entity): void {
                        foreach ($entity->getRelations() as $relationship) {
                            $relationships->{$relationship->getMethodName()}($relationship->getName());
                        }
                    });
            }
        });

        return $this;
    }

    private function getResourceRegistrar(): ResourceRegistrar
    {
        return new ResourceRegistrar($this->router, $this->server);
    }
}

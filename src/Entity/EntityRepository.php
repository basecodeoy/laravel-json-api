<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Entity;

use BombenProdukt\JsonApi\Server\ServerInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use RuntimeException;

final class EntityRepository implements EntityRepositoryInterface
{
    private Collection $entities;

    public function __construct(
        private readonly ServerInterface $server,
        array $entities,
    ) {
        $this->entities = new Collection();

        foreach ($entities as $entity) {
            $this->register($entity);
        }
    }

    /**
     * @return Collection<int, EntityInterface>
     */
    public function all(): Collection
    {
        return $this->entities;
    }

    public function findByModel(string $model): EntityInterface
    {
        return $this->findBy('getModel', $model);
    }

    public function findByModelName(string $modelName): EntityInterface
    {
        return $this->findBy('getModelName', $modelName);
    }

    public function findByResourceType(string $resourceType): EntityInterface
    {
        return $this->findBy(
            'getResourceType',
            Str::of($resourceType)->plural()->kebab()->toString(),
        );
    }

    public function findByResourceName(string $resourceName): EntityInterface
    {
        return $this->findBy('getResourceName', $resourceName);
    }

    public function register(string|EntityInterface $entity): void
    {
        if (\is_string($entity)) {
            /**
             * @var EntityInterface $entity
             */
            $entity = App::make($entity, [
                'server' => $this->server,
            ]);
        }

        $this->entities[] = $entity;
    }

    private function findBy(string $property, string $value): EntityInterface
    {
        return $this->entities
            ->filter(fn (EntityInterface $entity) => $entity->{$property}() === $value)
            ->first(null, fn () => throw new RuntimeException('Entity not found'));
    }
}

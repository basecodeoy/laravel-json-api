<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Server;

use BombenProdukt\JsonApi\Entity\EntityInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class EloquentRepository
{
    public function __construct(private ServerInterface $server) {}

    public function findOrFail(string $resourceType, mixed $resourceId): Model
    {
        return $this->getModel($resourceType)::findOrFail($resourceId);
    }

    public function create(EntityInterface $entity, array $data, array $relationships = []): Model
    {
        return $entity->getModel()::create($data);
    }

    public function update(Model $resource, array $data): bool
    {
        return $resource->update($data);
    }

    public function delete(Model $resource): bool
    {
        return (bool) $resource->delete();
    }

    public function attach(Model $resource, string $relation, array $ids): void
    {
        $resource->{$relation}()->attach($ids);
    }

    public function detach(Model $resource, string $relation, array $ids): void
    {
        $resource->{$relation}()->detach($ids);
    }

    public function sync(Model $resource, string $relation, array $ids): void
    {
        $resource->{$relation}()->sync($ids);
    }

    public function associate(Model $resource, string $relation, Model $relationModel): void
    {
        $resource->{$relation}()->associate($relationModel);
        $resource->save();
    }

    private function getModel(string $resourceType): string
    {
        return $this->server->getEntityRepository()->findByResourceType($resourceType)->getModel();
    }
}

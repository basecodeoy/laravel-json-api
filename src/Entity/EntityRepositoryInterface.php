<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Entity;

use Illuminate\Support\Collection;
use RuntimeException;

interface EntityRepositoryInterface
{
    /**
     * @return Collection<int, EntityInterface>
     */
    public function all(): Collection;

    /**
     * @throws RuntimeException
     */
    public function findByModel(string $model): EntityInterface;

    /**
     * @throws \RuntimeException
     */
    public function findByModelName(string $modelName): EntityInterface;

    /**
     * @throws \RuntimeException
     */
    public function findByResourceType(string $resourceType): EntityInterface;

    /**
     * @throws \RuntimeException
     */
    public function findByResourceName(string $resourceName): EntityInterface;

    public function register(string|EntityInterface $entity): void;
}

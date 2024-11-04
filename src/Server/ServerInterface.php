<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Server;

use BaseCodeOy\JsonApi\Entity\EntityInterface;
use BaseCodeOy\JsonApi\Entity\EntityRepository;
use BaseCodeOy\JsonApi\Resource\Model\Implementation;

interface ServerInterface
{
    public function getImplementation(): Implementation;

    public function getVersion(): string;

    /**
     * @return array<class-string<EntityInterface>>
     */
    public function getEntities(): array;

    public function getEntityRepository(): EntityRepository;

    public function getEloquentRepository(): EloquentRepository;

    public function shouldAuthorize(EntityInterface $entity): bool;
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Server;

use BombenProdukt\JsonApi\Entity\EntityInterface;
use BombenProdukt\JsonApi\Entity\EntityRepository;
use BombenProdukt\JsonApi\Resource\Model\Implementation;

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

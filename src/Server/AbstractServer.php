<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Server;

use BaseCodeOy\JsonApi\Entity\EntityInterface;
use BaseCodeOy\JsonApi\Entity\EntityRepository;
use BaseCodeOy\JsonApi\Resource\Model\Implementation;

abstract class AbstractServer implements ServerInterface
{
    private EntityRepository $entityRepository;

    private EloquentRepository $eloquentRepository;

    public function __construct()
    {
        $this->entityRepository = new EntityRepository($this, $this->getEntities());
        $this->eloquentRepository = new EloquentRepository($this);
    }

    public function getImplementation(): Implementation
    {
        return new Implementation('1.1');
    }

    public function getEntityRepository(): EntityRepository
    {
        return $this->entityRepository;
    }

    public function getEloquentRepository(): EloquentRepository
    {
        return $this->eloquentRepository;
    }

    public function shouldAuthorize(EntityInterface $entity): bool
    {
        return false;
    }
}

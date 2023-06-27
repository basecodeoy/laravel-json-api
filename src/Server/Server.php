<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Server;

use BombenProdukt\JsonApi\Entity\EntityInterface;
use BombenProdukt\JsonApi\Entity\EntityRepository;
use BombenProdukt\JsonApi\Resource\Model\Implementation;
use Illuminate\Support\Facades\Facade;

/**
 * @method static EloquentRepository getEloquentRepository()
 * @method static array              getEntities()
 * @method static EntityRepository   getEntityRepository()
 * @method static Implementation     getImplementation()
 * @method static string             getVersion()
 * @method static bool               shouldAuthorize(EntityInterface $entity)
 */
final class Server extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ServerInterface::class;
    }
}

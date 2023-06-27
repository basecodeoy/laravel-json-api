<?php

declare(strict_types=1);

namespace Tests\JsonApi\Server;

use BombenProdukt\JsonApi\Server\AbstractServer;
use Tests\JsonApi\Entity\CommentEntity;
use Tests\JsonApi\Entity\ImageEntity;
use Tests\JsonApi\Entity\PostEntity;
use Tests\JsonApi\Entity\UserEntity;

final class Server extends AbstractServer
{
    public function getVersion(): string
    {
        return 'v1';
    }

    /**
     * @return array<class-string<EntityInterface>>
     */
    public function getEntities(): array
    {
        return [
            CommentEntity::class,
            ImageEntity::class,
            PostEntity::class,
            UserEntity::class,
        ];
    }
}

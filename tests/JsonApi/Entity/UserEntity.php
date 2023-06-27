<?php

declare(strict_types=1);

namespace Tests\JsonApi\Entity;

use BombenProdukt\JsonApi\Entity\AbstractEntity;
use BombenProdukt\JsonApi\Entity\Relations\HasMany;
use Tests\Request\StoreUserRequest;
use Tests\Request\UpdateUserRequest;

final class UserEntity extends AbstractEntity
{
    public function allowedIncludes(): array
    {
        return ['posts', 'posts.comments'];
    }

    public function getStoreFormRequest(): ?string
    {
        return StoreUserRequest::class;
    }

    public function getUpdateFormRequest(): ?string
    {
        return UpdateUserRequest::class;
    }

    public function getRelations(): array
    {
        return [
            HasMany::make('posts'),
        ];
    }
}

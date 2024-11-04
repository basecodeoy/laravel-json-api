<?php

declare(strict_types=1);

namespace Tests\JsonApi\Entity;

use BaseCodeOy\JsonApi\Entity\AbstractEntity;
use BaseCodeOy\JsonApi\Entity\Relations\BelongsTo;
use BaseCodeOy\JsonApi\Entity\Relations\HasMany;
use BaseCodeOy\JsonApi\Entity\Relations\HasOne;
use BaseCodeOy\JsonApi\Entity\Relations\MorphToMany;

final class PostEntity extends AbstractEntity
{
    public function getRelations(): array
    {
        return [
            BelongsTo::make('user'),
            HasMany::make('comments'),
            HasOne::make('image'),
            MorphToMany::make('tags'),
        ];
    }
}

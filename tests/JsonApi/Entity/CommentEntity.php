<?php

declare(strict_types=1);

namespace Tests\JsonApi\Entity;

use BaseCodeOy\JsonApi\Entity\AbstractEntity;
use BaseCodeOy\JsonApi\Entity\Relations\BelongsTo;

final class CommentEntity extends AbstractEntity
{
    public function getRelations(): array
    {
        return [
            BelongsTo::make('post'),
            BelongsTo::make('user'),
        ];
    }
}

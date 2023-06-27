<?php

declare(strict_types=1);

namespace Tests\JsonApi\Entity;

use BombenProdukt\JsonApi\Entity\AbstractEntity;
use BombenProdukt\JsonApi\Entity\Relations\BelongsTo;

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

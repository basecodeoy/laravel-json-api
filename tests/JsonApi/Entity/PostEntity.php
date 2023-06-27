<?php

declare(strict_types=1);

namespace Tests\JsonApi\Entity;

use BombenProdukt\JsonApi\Entity\AbstractEntity;
use BombenProdukt\JsonApi\Entity\Relations\BelongsTo;
use BombenProdukt\JsonApi\Entity\Relations\HasMany;
use BombenProdukt\JsonApi\Entity\Relations\HasOne;
use BombenProdukt\JsonApi\Entity\Relations\MorphToMany;

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

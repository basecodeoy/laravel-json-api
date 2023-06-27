<?php

declare(strict_types=1);

namespace Tests\JsonApi\Resource;

use BombenProdukt\JsonApi\Resource\AbstractResource;

final class TagResource extends AbstractResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'name',
    ];
}

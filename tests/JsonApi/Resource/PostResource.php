<?php

declare(strict_types=1);

namespace Tests\JsonApi\Resource;

use BaseCodeOy\JsonApi\Resource\AbstractResource;

final class PostResource extends AbstractResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'name',
    ];

    /**
     * @var array<int|string, string>
     */
    public $relationships = [
        'user',
        'comments',
        'image',
        'tags',
    ];
}

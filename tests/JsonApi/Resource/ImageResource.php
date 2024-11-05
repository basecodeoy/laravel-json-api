<?php

declare(strict_types=1);

namespace Tests\JsonApi\Resource;

use BaseCodeOy\JsonApi\Resource\AbstractResource;

final class ImageResource extends AbstractResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'name',
    ];
}

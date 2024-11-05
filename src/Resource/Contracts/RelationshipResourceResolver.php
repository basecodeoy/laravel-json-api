<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Contracts;

use BaseCodeOy\JsonApi\Resource\AbstractResource;

interface RelationshipResourceResolver
{
    public function resolve(string $relationship, AbstractResource $resource): string;
}

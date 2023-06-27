<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Contracts;

use BombenProdukt\JsonApi\Resource\AbstractResource;

interface RelationshipResourceResolver
{
    public function resolve(string $relationship, AbstractResource $resource): string;
}

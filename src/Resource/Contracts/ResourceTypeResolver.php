<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Contracts;

use Illuminate\Http\Request;

interface ResourceTypeResolver
{
    public function resolve(mixed $resource, Request $request): string;
}

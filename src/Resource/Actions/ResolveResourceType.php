<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Actions;

use BombenProdukt\JsonApi\Resource\Contracts\ResourceTypeResolver;
use BombenProdukt\JsonApi\Resource\Exceptions\ResourceIdentificationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class ResolveResourceType implements ResourceTypeResolver
{
    public function resolve(mixed $resource, Request $request): string
    {
        if ($resource instanceof Model) {
            return Str::camel($resource->getTable());
        }

        throw ResourceIdentificationException::attemptingToDetermineTypeFor($resource);
    }
}

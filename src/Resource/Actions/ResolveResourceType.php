<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Actions;

use BaseCodeOy\JsonApi\Resource\Contracts\ResourceTypeResolver;
use BaseCodeOy\JsonApi\Resource\Exceptions\ResourceIdentificationException;
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

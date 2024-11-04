<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Actions;

use BaseCodeOy\JsonApi\Resource\Contracts\ResourceIdResolver;
use BaseCodeOy\JsonApi\Resource\Exceptions\ResourceIdentificationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class ResolveResourceId implements ResourceIdResolver
{
    public function resolve(mixed $resource, Request $request): string
    {
        if ($resource instanceof Model) {
            return (string) $resource->getKey();
        }

        throw ResourceIdentificationException::attemptingToDetermineIdFor($resource);
    }
}

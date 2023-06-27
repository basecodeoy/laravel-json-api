<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Actions;

use BombenProdukt\JsonApi\Resource\Contracts\ResourceIdResolver;
use BombenProdukt\JsonApi\Resource\Exceptions\ResourceIdentificationException;
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

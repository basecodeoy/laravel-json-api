<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Exceptions;

use BaseCodeOy\JsonApi\Resource\AbstractResource;
use BaseCodeOy\JsonApi\Resource\AbstractResourceCollection;
use Exception;

final class UnknownRelationshipException extends Exception
{
    public static function from(mixed $resource): static
    {
        return new self('Unknown relationship encountered. Relationships should always return a class that extends '.AbstractResource::class.' or '.AbstractResourceCollection::class.'. Instead found ['.self::determineType($resource).'].');
    }

    private static function determineType(mixed $resource): string
    {
        if (\is_object($resource)) {
            return $resource::class;
        }

        return \gettype($resource);
    }
}

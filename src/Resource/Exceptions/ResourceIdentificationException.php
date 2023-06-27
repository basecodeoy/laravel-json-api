<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Exceptions;

use RuntimeException;

final class ResourceIdentificationException extends RuntimeException
{
    public static function attemptingToDetermineIdFor(mixed $resource): static
    {
        return new self('Unable to resolve resource object id for ['.self::determineType($resource).'].');
    }

    public static function attemptingToDetermineTypeFor(mixed $resource): static
    {
        return new self('Unable to resolve resource object type for ['.self::determineType($resource).'].');
    }

    private static function determineType(mixed $resource): string
    {
        if (\is_object($resource)) {
            return $resource::class;
        }

        return \gettype($resource);
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi;

use BombenProdukt\JsonApi\Resource\Contracts\RelationshipResourceResolver;
use BombenProdukt\JsonApi\Resource\Contracts\ResourceIdResolver;
use BombenProdukt\JsonApi\Resource\Contracts\ResourceTypeResolver;
use Illuminate\Support\Facades\App;

final class JsonApi
{
    public static function resolveRelationshipResourceUsing(string $class): void
    {
        App::singleton(RelationshipResourceResolver::class, $class);
    }

    public static function resolveResourceIdUsing(string $class): void
    {
        App::singleton(ResourceIdResolver::class, $class);
    }

    public static function resolveResourceTypeUsing(string $class): void
    {
        App::singleton(ResourceTypeResolver::class, $class);
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Actions;

use BaseCodeOy\JsonApi\Resource\AbstractResource;
use BaseCodeOy\JsonApi\Resource\Contracts\RelationshipResourceResolver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use RuntimeException;

final class ResolveRelationshipResource implements RelationshipResourceResolver
{
    public function resolve(string $relationship, AbstractResource $resource): string
    {
        $relationship = Str::of($relationship);

        foreach ([
            Config::get('json-api.namespace_json-api')."\\Resource\\{$relationship->singular()->studly()}Resource",
            Config::get('json-api.namespace_json-api')."\\Resource\\{$relationship->studly()}Resource",
        ] as $class) {
            if (\class_exists($class)) {
                return $class;
            }
        }

        throw new RuntimeException('Unable to guess the resource class for relationship ['.$relationship.'] for ['.$resource::class.'].');
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Route;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin Route
 *
 * @method static string             getApiVersion()
 * @method static EloquentRepository getEloquentRepository()
 * @method static Model              getModel()
 * @method static ?string            getResourceName()
 * @method static ?string            getResourceRelationship()
 * @method static string             getResourceType()
 * @method static bool               hasResourceName()
 * @method static bool               hasResourceRelationship()
 */
final class CurrentRoute extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RouterInterface::class;
    }
}

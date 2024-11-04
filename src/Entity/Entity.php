<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Entity;

use BaseCodeOy\JsonApi\Entity\Relations\RelationRepository;
use BaseCodeOy\JsonApi\Server\ServerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Facade;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @method static array                       allowedFields()
 * @method static array                       allowedFilters()
 * @method static array                       allowedIncludes()
 * @method static array                       allowedSorts()
 * @method static string                      getModel()
 * @method static string                      getModelName()
 * @method static RelationRepository          getRelationRepository()
 * @method static array                       getRelations()
 * @method static string                      getResource()
 * @method static string                      getResourceName()
 * @method static string                      getResourceType()
 * @method static ServerInterface             getServer()
 * @method static ?string                     getStoreFormRequest()
 * @method static ?string                     getUpdateFormRequest()
 * @method static AnonymousResourceCollection toCollection(mixed $data)
 * @method static QueryBuilder                toQueryBuilder(Request $request)
 * @method static JsonResource                toResource(mixed $data)
 */
final class Entity extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EntityInterface::class;
    }
}

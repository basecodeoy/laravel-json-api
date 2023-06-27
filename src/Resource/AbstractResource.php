<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource;

use BombenProdukt\JsonApi\Resource\Actions\ParseLinks;
use BombenProdukt\JsonApi\Resource\Concerns\Caching;
use BombenProdukt\JsonApi\Resource\Concerns\HasAttributes;
use BombenProdukt\JsonApi\Resource\Concerns\HasIdentification;
use BombenProdukt\JsonApi\Resource\Concerns\HasLinks;
use BombenProdukt\JsonApi\Resource\Concerns\HasMeta;
use BombenProdukt\JsonApi\Resource\Concerns\HasRelationshipLinks;
use BombenProdukt\JsonApi\Resource\Concerns\HasRelationships;
use BombenProdukt\JsonApi\Resource\Concerns\InteractsWithQueryBuilder;
use BombenProdukt\JsonApi\Resource\Concerns\WithSortedResponse;
use BombenProdukt\JsonApi\Resource\Contracts\ResourceIdResolver;
use BombenProdukt\JsonApi\Resource\Contracts\ResourceTypeResolver;
use BombenProdukt\JsonApi\Resource\Model\Link;
use BombenProdukt\JsonApi\Resource\Model\ResourceIdentifier;
use BombenProdukt\JsonApi\Server\Server;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\PotentiallyMissing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

abstract class AbstractResource extends JsonResource
{
    use Caching;
    use HasAttributes;
    use HasIdentification;
    use HasLinks;
    use HasMeta;
    use HasRelationshipLinks;
    use HasRelationships;
    use InteractsWithQueryBuilder;
    use WithSortedResponse;

    public static function makeMany(self $parent, string $relation, Collection $resource)
    {
        $collection = static::newCollection($resource);
        $collection->setRelation($relation);
        $collection->setParent($parent);

        return $collection;
    }

    /**
     * @return AbstractResourceCollection<int, mixed>
     */
    public static function newCollection(mixed $resource): AbstractResourceCollection
    {
        return new AbstractResourceCollection($resource, static::class);
    }

    public function with($request): array
    {
        $document = [
            'jsonapi' => Server::getImplementation(),
        ];

        $included = $this
            ->included($request)
            ->uniqueStrict(fn (AbstractResource $resource): string => $resource->toUniqueResourceIdentifier($request))
            ->values();

        if (\count($included) > 0) {
            $document['included'] = $included;
        }

        $links = \array_merge($this->toTopLevelLinks($request), $this->links);

        if (\count($links) > 0) {
            $document['links'] = ParseLinks::execute($links);
        }

        return $document;
    }

    /**
     * @return array<string, mixed>
     */
    public function toAttributes(Request $request)
    {
        return [
            //
        ];
    }

    /**
     * @return array<string, (AbstractResourceCollection|callable(): AbstractResource|PotentiallyMissing)>
     */
    public function toRelationships(Request $request)
    {
        return [
            //
        ];
    }

    /**
     * @return array<int, Link>
     */
    public function toLinks(Request $request)
    {
        return [
            $this->toSelfLink(),
        ];
    }

    /**
     * @return array<int, Link>
     */
    public function toTopLevelLinks(Request $request)
    {
        return [
            $this->toSelfLink(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toMeta(Request $request)
    {
        return [
            //
        ];
    }

    public function toResourceIdentifier(Request $request): ResourceIdentifier
    {
        return new ResourceIdentifier($this->resolveType($request), $this->resolveId($request));
    }

    public function toArray($request)
    {
        $document = [
            'type' => $this->resolveType($request),
            'id' => $this->resolveId($request),
            'attributes' => $this->requestedAttributes($request)->all(),
        ];

        $relationships = $this->requestedRelationshipsAsIdentifiers($request)->all();

        if (\count($relationships) > 0) {
            $document['relationships'] = $relationships;
        }

        $meta = \array_merge($this->toMeta($request), $this->meta);

        if (\count($meta) > 0) {
            $document['meta'] = $meta;
        }

        $links = ParseLinks::execute(\array_merge($this->toLinks($request), $this->links));

        if (\count($links) > 0) {
            $document['links'] = $links;
        }

        return $document;
    }

    public function toResponse($request): JsonResponse
    {
        return tap(
            parent::toResponse($request)->header('Content-type', 'application/vnd.api+json'),
            fn () => $this->flush(),
        );
    }

    private function toId(Request $request): string
    {
        return App::get(ResourceIdResolver::class)->resolve($this->resource, $request);
    }

    private function toType(Request $request): string
    {
        return App::get(ResourceTypeResolver::class)->resolve($this->resource, $request);
    }
}

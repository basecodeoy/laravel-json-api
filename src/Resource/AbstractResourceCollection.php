<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource;

use BaseCodeOy\JsonApi\Resource\Concerns\HasRelationshipLinks;
use BaseCodeOy\JsonApi\Resource\Concerns\WithSortedResponse;
use BaseCodeOy\JsonApi\Resource\Model\RelationshipLink;
use BaseCodeOy\JsonApi\Resource\Model\ResourceIdentifier;
use BaseCodeOy\JsonApi\Server\Server;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

final class AbstractResourceCollection extends AnonymousResourceCollection
{
    use HasRelationshipLinks;
    use WithSortedResponse;

    private string $relation;

    private AbstractResource $parent;

    public function __construct($resource, $collects)
    {
        parent::__construct($resource, $collects);

        foreach ($this->collection as $collect) {
            $entity = Server::getEntityRepository()->findByModel(\get_class($collect->resource));

            $collect->setAllowedFields($entity->allowedFields());
            $collect->setAllowedIncludes($entity->allowedIncludes());
        }
    }

    public function with($request)
    {
        return [
            'jsonapi' => Server::getImplementation(),
            'included' => $this->collection
                ->map(fn (AbstractResource $resource): Collection => $resource->included($request))
                ->flatten()
                ->uniqueStrict(fn (AbstractResource $resource): string => $resource->toUniqueResourceIdentifier($request))
                ->values(),
        ];
    }

    public function paginationInformation($request, $paginated, $default)
    {
        if (isset($default['links'])) {
            $default['links'] = \array_filter($default['links'], fn (?string $link): bool => $link !== null);
        }

        if (isset($default['meta']['links'])) {
            $default['meta']['links'] = \array_map(
                function (array $link): array {
                    $link['label'] = (string) $link['label'];

                    return $link;
                },
                $default['meta']['links'],
            );
        }

        return $default;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function setParent(AbstractResource $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function map(callable $callback): static
    {
        $this->collection = $this->collection->map($callback);

        return $this;
    }

    public function toRelationshipLink(Request $request): RelationshipLink
    {
        return RelationshipLink::toMany(
            $this->toResourceIdentifiers($request)->all(),
            [
                $this->parent->toSelfLinkWithRelationship($this->parent, $this->relation),
                $this->parent->toRelatedLinkWithRelationship($this->parent, $this->relation),
            ],
        );
    }

    public function toResponse($request): JsonResponse
    {
        return tap(
            parent::toResponse($request)->header('Content-type', 'application/vnd.api+json'),
            fn () => $this->flush(),
        );
    }

    public function withIncludePrefix(string $prefix): static
    {
        return tap($this, function (self $resource) use ($prefix): void {
            $resource->collection->each(fn (AbstractResource $resource): AbstractResource => $resource->withIncludePrefix($prefix));
        });
    }

    /**
     * @return Collection<int, Collection<int, AbstractResource>>
     */
    public function included(Request $request): Collection
    {
        return $this->collection->map(fn (AbstractResource $resource): Collection => $resource->included($request));
    }

    /**
     * @return Collection<int, AbstractResource>
     */
    public function includable(): Collection
    {
        return $this->collection;
    }

    /**/
    public function flush(): void
    {
        $this->collection->each(fn (AbstractResource $resource) => $resource->flush());
    }

    /**
     * @return Collection<int, ResourceIdentifier>
     */
    private function toResourceIdentifiers(Request $request)
    {
        return $this->collection
            ->uniqueStrict(fn (AbstractResource $resource): string => $resource->toUniqueResourceIdentifier($request))
            ->map(fn (AbstractResource $resource): ResourceIdentifier => $resource->toResourceIdentifier($request));
    }
}

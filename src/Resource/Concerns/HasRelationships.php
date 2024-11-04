<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

use BaseCodeOy\JsonApi\Resource\AbstractResource;
use BaseCodeOy\JsonApi\Resource\AbstractResourceCollection;
use BaseCodeOy\JsonApi\Resource\Contracts\RelationshipResourceResolver;
use BaseCodeOy\JsonApi\Resource\Exceptions\UnknownRelationshipException;
use BaseCodeOy\JsonApi\Resource\Model\RelationshipLink;
use BaseCodeOy\JsonApi\Resource\Support\Includes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\PotentiallyMissing;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Traversable;

trait HasRelationships
{
    private string $includePrefix = '';

    public function withIncludePrefix(string $prefix): static
    {
        $this->includePrefix = "{$this->includePrefix}{$prefix}.";

        return $this;
    }

    /**
     * @return Collection<int, AbstractResource>
     */
    public function included(Request $request)
    {
        return $this
            ->requestedRelationships($request)
            ->map(fn (AbstractResource|AbstractResourceCollection $include): Collection|AbstractResource => $include->includable())
            // ->merge($this->nestedIncluded($request))
            ->flatten()
            ->filter(fn (AbstractResource $resource): bool => $resource->shouldBePresentInIncludes())
            ->values();
    }

    /**
     * @return Collection<int, AbstractResource>
     */
    private function nestedIncluded(Request $request)
    {
        return $this
            ->requestedRelationships($request)
            ->flatMap(fn (AbstractResource|AbstractResourceCollection $resource): Collection => $resource->included($request));
    }

    /**
     * @return Collection<string, RelationshipLink>
     */
    private function requestedRelationshipsAsIdentifiers(Request $request)
    {
        return $this
            ->requestedRelationships($request)
            ->map(fn (AbstractResource|AbstractResourceCollection $resource, string $relationship): RelationshipLink => $resource->toRelationshipLink($request, $this, $relationship));
    }

    /**
     * @return Collection<string, AbstractResource|AbstractResourceCollection>
     */
    private function requestedRelationships(Request $request)
    {
        return $this
            ->rememberRequestRelationships(fn (): Collection => $this->resolveRelationships($request)
                ->only($this->requestedIncludes($request))
                ->map(fn (callable $value, string $prefix): AbstractResource|AbstractResourceCollection|null => $this->resolveInclude($value(), $prefix))
                ->reject(fn (AbstractResource|AbstractResourceCollection|null $resource): bool => $resource === null));
    }

    private function resolveInclude(mixed $resource, string $prefix): null|AbstractResource|AbstractResourceCollection
    {
        return match (true) {
            $resource instanceof PotentiallyMissing && $resource->isMissing() => null,
            $resource instanceof AbstractResource => $resource->withIncludePrefix($prefix),
            $resource instanceof AbstractResourceCollection => $resource->withIncludePrefix($prefix),
            default => throw UnknownRelationshipException::from($resource),
        };
    }

    /**
     * @return Collection<string, AbstractResourceCollection|Closure(): AbstractResource>
     */
    private function resolveRelationships(Request $request)
    {
        return Collection::make(\property_exists($this, 'relationships') ? $this->relationships : [])
            ->mapWithKeys(function (string $value, int|string $key): array {
                if (\is_int($key)) {
                    return [
                        $value => App::get(RelationshipResourceResolver::class)->resolve($value, $this),
                    ];
                }

                return [
                    $key => $value,
                ];
            })
            ->map(fn (string $class, string $relation): Closure => function () use ($class, $relation) {
                return with($this->resource->{$relation}, function (mixed $resource) use ($class, $relation): AbstractResource|AbstractResourceCollection {
                    if ($resource instanceof Traversable || (\is_array($resource) && !Arr::isAssoc($resource))) {
                        return $class::makeMany($this, $relation, $resource);
                    }

                    return $class::make($resource);
                });
            })
            ->merge($this->toRelationships($request));
    }

    /**
     * @return array<int, string>
     */
    private function requestedIncludes(Request $request): array
    {
        return App::get(Includes::class)->forPrefix($request, $this->includePrefix);
    }

    private function includable(): static
    {
        return $this;
    }

    private function shouldBePresentInIncludes(): bool
    {
        return $this->resource !== null;
    }
}

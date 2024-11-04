<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

use BaseCodeOy\JsonApi\Resource\AbstractResource;
use BaseCodeOy\JsonApi\Resource\AbstractResourceCollection;
use Illuminate\Support\Collection;

trait Caching
{
    private ?string $idCache = null;

    private ?string $typeCache = null;

    /**
     * @var null|Collection<string, AbstractResource|AbstractResourceCollection>
     */
    private ?Collection $requestedRelationshipsCache = null;

    /**/
    public function flush(): void
    {
        $this->idCache = null;

        $this->typeCache = null;

        if ($this->requestedRelationshipsCache !== null) {
            $this->requestedRelationshipsCache->each(fn (AbstractResource|AbstractResourceCollection $relation) => $relation->flush());
        }

        $this->requestedRelationshipsCache = null;
    }

    /**
     * @return null|Collection<string, AbstractResource|AbstractResourceCollection>
     */
    public function requestedRelationshipsCache()
    {
        return $this->requestedRelationshipsCache;
    }

    private function rememberId(callable $callback): string
    {
        return $this->idCache ??= $callback();
    }

    private function rememberType(callable $callback): string
    {
        return $this->typeCache ??= $callback();
    }

    private function rememberRequestRelationships(callable $callback)
    {
        return $this->requestedRelationshipsCache ??= $callback();
    }
}

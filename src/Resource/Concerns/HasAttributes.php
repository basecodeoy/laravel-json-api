<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

use BaseCodeOy\JsonApi\Resource\Support\Fields;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\PotentiallyMissing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

trait HasAttributes
{
    /**
     * @return Collection<string, mixed>
     */
    private function requestedAttributes(Request $request)
    {
        return Collection::make($this->resolveAttributes($request))
            ->only($this->requestedFields($request))
            ->map(fn (mixed $value): mixed => value($value))
            ->reject(fn (mixed $value): bool => $value instanceof PotentiallyMissing && $value->isMissing());
    }

    /**
     * @return Collection<string, mixed>
     */
    private function resolveAttributes(Request $request)
    {
        return Collection::make(\property_exists($this, 'attributes') ? $this->attributes : [])
            ->mapWithKeys(fn (string $attribute): array => [
                $attribute => fn () => $this->resource->{$attribute},
            ])
            ->merge($this->toAttributes($request));
    }

    /**
     * @return null|array<int, string>
     */
    private function requestedFields(Request $request)
    {
        return App::get(Fields::class)->parse($request, $this->toType($request));
    }
}

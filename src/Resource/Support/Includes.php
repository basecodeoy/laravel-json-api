<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use WeakMap;

final class Includes
{
    /**
     * @var WeakMap<Request, array<string, Collection<int, non-empty-string>>>
     */
    private WeakMap $cache;

    public function __construct()
    {
        $this->cache = new WeakMap();
    }

    /**
     * @return array<int, string>
     */
    public function forPrefix(Request $request, string $prefix)
    {
        return $this->rememberIncludes($request, $prefix, function () use ($request, $prefix): Collection {
            return $this->all($request)
                ->when($prefix !== '')
                ->filter(fn (string $include): bool => \str_starts_with($include, $prefix))
                ->map(fn ($include): string => (string) Str::of($include)->after($prefix)->before('.'))
                ->uniqueStrict()
                ->values();
        })->all();
    }

    public function flush(): void
    {
        $this->cache = new WeakMap();
    }

    /**
     * @return Collection<int, non-empty-string>
     */
    private function all(Request $request): Collection
    {
        return $this->rememberIncludes($request, '__all__', function () use ($request) {
            $includes = $request->query('include') ?? '';

            if (\is_array($includes)) {
                throw new HttpException(400, 'The include parameter must be a comma seperated list of relationship paths.');
            }

            return Collection::make(\explode(',', $includes))->filter(fn (string $include): bool => $include !== '');
        });
    }

    private function rememberIncludes(Request $request, string $prefix, callable $callback): Collection
    {
        $this->cache[$request] ??= [];

        return $this->cache[$request][$prefix] ??= $callback();
    }
}

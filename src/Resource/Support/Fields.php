<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Support;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use WeakMap;

final class Fields
{
    /**
     * @var WeakMap<Request, array<string, null|array<int, string>>>
     */
    private WeakMap $cache;

    public function __construct()
    {
        $this->cache = new WeakMap();
    }

    /**
     * @return null|array<int, string>
     */
    public function parse(Request $request, string $resourceType)
    {
        return $this->rememberResourceType($request, "type:{$resourceType};", function () use ($request, $resourceType): ?array {
            $typeFields = $request->query('fields') ?? [];

            if (\is_string($typeFields)) {
                throw new HttpException(400, 'The fields parameter must be an array of resource types.');
            }

            if (!\array_key_exists($resourceType, $typeFields)) {
                return null;
            }

            $fields = $typeFields[$resourceType] ?? '';

            if (!\is_string($fields)) {
                throw new HttpException(400, 'The fields parameter value must be a comma seperated list of attributes.');
            }

            return \array_filter(\explode(',', $fields), fn (string $value): bool => $value !== '');
        });
    }

    public function flush(): void
    {
        $this->cache = new WeakMap();
    }

    private function rememberResourceType(Request $request, string $resourceType, callable $callback)
    {
        $this->cache[$request] ??= [];

        return $this->cache[$request][$resourceType] ??= $callback();
    }
}

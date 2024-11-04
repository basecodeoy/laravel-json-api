<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

use Illuminate\Http\Request;

trait HasIdentification
{
    public function toUniqueResourceIdentifier(Request $request): string
    {
        return "type:{$this->resolveType($request)};id:{$this->resolveId($request)};";
    }

    private function resolveId(Request $request): string
    {
        return $this->rememberId(fn (): string => $this->toId($request));
    }

    private function resolveType(Request $request): string
    {
        return $this->rememberType(fn (): string => $this->toType($request));
    }
}

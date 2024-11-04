<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Contracts;

use Illuminate\Http\Request;

interface ResourceIdResolver
{
    public function resolve(mixed $resource, Request $request): string;
}

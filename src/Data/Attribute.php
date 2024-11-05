<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class Attribute implements ResourceField
{
    private string|int|float|bool|null|array|object $val;

    public function __construct(private readonly string $name, $val)
    {
        $this->val = $val;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attachTo(array $data): array
    {
        Arr::set($data, "attributes.{$this->name}", $this->val);

        return $data;
    }
}

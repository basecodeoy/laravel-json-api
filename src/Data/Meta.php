<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class Meta implements MemberInterface
{
    public function __construct(
        private readonly string $key,
        private readonly string|int|float|bool|null|array|object $value,
    ) {}

    public function attachTo(array $data): array
    {
        Arr::set($data, "meta.{$this->key}", $this->value);

        return $data;
    }
}

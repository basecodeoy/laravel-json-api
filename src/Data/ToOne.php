<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class ToOne implements Identifier, ResourceField
{
    private readonly array $data;

    public function __construct(
        private readonly string $name,
        private readonly ResourceIdentifier $identifier,
        MemberInterface ...$members,
    ) {
        $this->data = combine($identifier, ...$members);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attachTo(array $data): array
    {
        Arr::set($data, "relationships.{$this->name}", $this->data);

        return $data;
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class EmptyRelationship implements ResourceField
{
    private array $data;

    public function __construct(
        private readonly string $name,
        MemberInterface $member,
        MemberInterface ...$members,
    ) {
        $this->data = combine($member, ...$members);
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

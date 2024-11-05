<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class ToNull implements ResourceField
{
    /**
     * @var MemberInterface[]
     */
    private readonly array $members;

    public function __construct(private readonly string $name, MemberInterface ...$members)
    {
        $this->members = $members;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attachTo(array $data): array
    {
        $members = combine(...$this->members);
        $members['data'] = null;

        Arr::set($data, "relationships.{$this->name}", $members);

        return $data;
    }
}

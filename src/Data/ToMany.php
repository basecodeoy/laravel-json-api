<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class ToMany implements Identifier, ResourceField
{
    /**
     * @var MemberInterface[]
     */
    private readonly array $members;

    public function __construct(
        private readonly string $name,
        private readonly ResourceIdentifierCollection $collection,
        MemberInterface ...$members,
    ) {
        $this->members = $members;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attachTo(array $data): array
    {
        $relationship = data_get($data, "relationships.{$this->name}", []);
        $relationship['data'] = [];

        $this->collection->attachTo($relationship);

        foreach ($this->members as $member) {
            $relationship = $member->attachTo($relationship);
        }

        Arr::set($data, "relationships.{$this->name}", $relationship);

        return $data;
    }
}

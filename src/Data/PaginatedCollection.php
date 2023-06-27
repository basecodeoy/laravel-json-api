<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

final class PaginatedCollection implements MemberInterface
{
    public function __construct(private readonly Pagination $pagination, private readonly MemberInterface $collection) {}

    public function attachTo(array $data): array
    {
        return $this->pagination->attachTo(
            $this->collection->attachTo($data),
        );
    }
}

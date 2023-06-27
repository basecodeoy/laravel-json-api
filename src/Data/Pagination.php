<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

final class Pagination implements MemberInterface
{
    /**
     * @var MemberInterface[]
     */
    private readonly array $links;

    public function __construct(MemberInterface ...$links)
    {
        $this->links = $links;
    }

    public function attachTo(array $data): array
    {
        foreach ($this->links as $link) {
            $data = $link->attachTo($data);
        }

        return $data;
    }
}

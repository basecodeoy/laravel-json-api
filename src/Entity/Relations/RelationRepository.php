<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Entity\Relations;

use Illuminate\Support\Collection;
use RuntimeException;

final readonly class RelationRepository
{
    private Collection $items;

    /**
     * @param RelationInterface[] $items
     */
    public function __construct(array $items)
    {
        $this->items = new Collection();

        foreach ($items as $item) {
            $this->items->put($item->getName(), $item);
        }
    }

    public function findByName(string $name): RelationInterface
    {
        return $this->items->get($name, fn () => throw new RuntimeException('Server not found'));
    }
}

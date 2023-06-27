<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Concerns;

use BombenProdukt\JsonApi\Resource\Model\Link;
use Illuminate\Support\Collection;

trait HasLinks
{
    /**
     * @var array<int, Link>
     */
    private array $links = [];

    public function withLink(Link $link): static
    {
        $this->links[] = $link;

        return $this;
    }

    public function withLinks(array $links): static
    {
        $this->links = \array_merge(
            $this->links,
            Collection::make($links)
                ->map(fn ($value, $key) => \is_string($key) ? new Link($key, $value) : $value)
                ->values()
                ->all(),
        );

        return $this;
    }
}

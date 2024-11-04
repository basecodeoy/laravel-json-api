<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

trait HasMeta
{
    /**
     * @var array<string, mixed>
     */
    private array $meta = [];

    public function withMeta(array $meta): static
    {
        $this->meta = \array_merge($this->meta, $meta);

        return $this;
    }
}

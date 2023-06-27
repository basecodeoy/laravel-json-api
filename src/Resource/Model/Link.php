<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Model;

use JsonSerializable;

final class Link implements JsonSerializable
{
    public function __construct(
        public string $key,
        public string $href,
        public ?string $title = null,
        public ?string $describedby = null,
        public array $meta = [],
    ) {
        //
    }

    public static function self(string $href, ?string $title = null, ?string $describedby = null, array $meta = []): static
    {
        return new self('self', $href, $title, $describedby, $meta);
    }

    public static function related(string $href, ?string $title = null, ?string $describedby = null, array $meta = []): static
    {
        return new self('related', $href, $title, $describedby, $meta);
    }

    public function jsonSerialize(): array|string
    {
        $hasTitle = $this->title !== null;
        $hasDescribedby = $this->describedby !== null;
        $hasMeta = \count($this->meta) > 0;

        if (!$hasTitle && !$hasDescribedby && !$hasMeta) {
            return $this->href;
        }

        return \array_filter([
            'href' => $this->href,
            'title' => $this->title,
            'describedby' => $this->describedby,
            'meta' => $this->meta,
        ]);
    }
}

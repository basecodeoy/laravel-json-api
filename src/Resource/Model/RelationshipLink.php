<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Model;

use BaseCodeOy\JsonApi\Resource\Actions\ParseLinks;
use BaseCodeOy\JsonApi\Resource\Concerns\HasLinks;
use BaseCodeOy\JsonApi\Resource\Concerns\HasMeta;
use JsonSerializable;

final class RelationshipLink implements JsonSerializable
{
    use HasLinks;
    use HasMeta;

    private function __construct(
        public ResourceIdentifier|array|null $data,
        array $links = [],
        array $meta = [],
    ) {
        $this->links = $links;
        $this->meta = $meta;
    }

    public static function toOne(?ResourceIdentifier $data, array $links = [], array $meta = []): static
    {
        return new self($data, $links, $meta);
    }

    public static function toMany(array $data, array $links = [], array $meta = []): static
    {
        return new self($data, $links, $meta);
    }

    public function jsonSerialize(): array
    {
        $result = [];

        if (\count($this->links) > 0) {
            $result['links'] = ParseLinks::execute($this->links);
        }

        $result['data'] = $this->data;

        if (\count($this->meta) > 0) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }
}

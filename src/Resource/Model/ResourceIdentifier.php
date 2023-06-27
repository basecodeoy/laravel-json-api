<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Model;

use JsonSerializable;

final class ResourceIdentifier implements JsonSerializable
{
    public function __construct(
        public string $type,
        public string $id,
        public array $meta = [],
    ) {
        //
    }

    public function jsonSerialize(): array
    {
        $result = [
            'type' => $this->type,
            'id' => $this->id,
        ];

        if ($this->meta) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }
}

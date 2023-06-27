<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Model;

use JsonSerializable;

final class Implementation implements JsonSerializable
{
    public function __construct(
        public readonly string $version,
        public readonly array $ext = [],
        public readonly array $profile = [],
        public readonly array $meta = [],
    ) {}

    public function jsonSerialize(): array
    {
        $result = [
            'version' => $this->version,
        ];

        if (\count($this->ext) > 0) {
            $result['ext'] = $this->ext;
        }

        if (\count($this->profile) > 0) {
            $result['profile'] = $this->profile;
        }

        if (\count($this->meta) > 0) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }
}

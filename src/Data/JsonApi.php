<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use JsonSerializable;

final class JsonApi implements JsonSerializable, MemberInterface
{
    private array $data;

    public function __construct(string $version = '1.1', ?Meta $meta = null)
    {
        $this->data = ['version' => $version];

        if ($meta instanceof Meta) {
            $this->data = $meta?->attachTo($this->data);
        }
    }

    public function attachTo(array $data): array
    {
        $data['jsonapi'] = $this->data;

        return $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

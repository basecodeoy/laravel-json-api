<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use JsonSerializable;

final class DataDocument implements JsonSerializable
{
    private array $value;

    public function __construct(MemberInterface $data, MemberInterface ...$members)
    {
        $this->value = combine($data, ...$members);
    }

    public function jsonSerialize(): array
    {
        return $this->value;
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use JsonSerializable;

final class MetaDocument implements JsonSerializable
{
    private readonly array $doc;

    public function __construct(Meta $meta, MemberInterface ...$members)
    {
        $this->doc = combine($meta, ...$members);
    }

    public function jsonSerialize(): array
    {
        return $this->doc;
    }
}

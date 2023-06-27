<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

use JsonSerializable;

final class CompoundDocument implements JsonSerializable
{
    private array $doc;

    public function __construct(MemberInterface $data, Included $included, MemberInterface ...$members)
    {
        $this->doc = combine($data, $included, ...$members);
    }

    public function jsonSerialize(): array
    {
        return $this->doc;
    }
}

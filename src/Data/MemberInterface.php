<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

interface MemberInterface
{
    public function attachTo(array $data): array;
}

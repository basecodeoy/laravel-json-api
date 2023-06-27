<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

interface ResourceField extends MemberInterface
{
    public function name(): string;
}

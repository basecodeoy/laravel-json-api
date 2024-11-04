<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

final class NullData implements MemberInterface
{
    public function attachTo(array $data): array
    {
        $data['data'] = null;

        return $data;
    }
}

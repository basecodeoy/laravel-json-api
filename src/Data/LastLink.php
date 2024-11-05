<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class LastLink extends AbstractLink
{
    public function attachTo(array $data): array
    {
        Arr::set($data, 'links.last', $this->link);

        return $data;
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use Illuminate\Support\Arr;

final class RelatedLink extends AbstractLink
{
    public function attachTo(array $data): array
    {
        Arr::set($data, 'links.related', $this->link);

        return $data;
    }
}

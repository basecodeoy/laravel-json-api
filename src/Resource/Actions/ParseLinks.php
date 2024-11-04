<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Actions;

use BaseCodeOy\JsonApi\Resource\Model\Link;
use Illuminate\Support\Collection;

final class ParseLinks
{
    public static function execute(array $links): array
    {
        return Collection::make($links)
            ->mapWithKeys(fn (Link $link): array => [$link->key => $link])
            ->all();
    }
}

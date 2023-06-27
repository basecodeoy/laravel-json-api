<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

function combine(MemberInterface ...$members): array
{
    $data = [];

    foreach ($members as $member) {
        $data = $member->attachTo($data);
    }

    return $data;
}

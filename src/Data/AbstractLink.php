<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

abstract class AbstractLink implements MemberInterface
{
    protected array|string $link;

    public function __construct(string $url, Meta ...$metas)
    {
        if ($metas) {
            $this->link = ['href' => $url];

            foreach ($metas as $meta) {
                $this->link = $meta->attachTo($this->link);
            }
        } else {
            $this->link = $url;
        }
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Paginator;

use Closure;

interface PaginatorInterface
{
    public function register(): Closure;
}

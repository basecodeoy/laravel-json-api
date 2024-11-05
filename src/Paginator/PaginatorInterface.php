<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Paginator;

use Closure;

interface PaginatorInterface
{
    public function register(): Closure;
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Paginator;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

final class CursorPaginator implements PaginatorInterface
{
    public function register(): Closure
    {
        return function (?int $maxResults = null, ?int $defaultSize = null) {
            $maxResults ??= Config::get('json-api.pagination.size_maximum');
            $defaultSize ??= Config::get('json-api.pagination.size_default');

            $size = (int) Request::query('page.size', $defaultSize);
            $cursor = (string) Request::query('page.cursor');

            if ($size <= 0) {
                $size = $defaultSize;
            }

            if ($size > $maxResults) {
                $size = $maxResults;
            }

            return $this
                ->cursorPaginate($size, ['*'], 'page[cursor]', $cursor)
                ->appends(Arr::except(Request::query(), 'page.cursor'));
        };
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Resource\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait WithSortedResponse
{
    /**
     * Customize the response for a request.
     */
    public function withResponse(Request $request, JsonResponse $response): void
    {
        $keys = ['jsonapi', 'links', 'data', 'included', 'meta'];

        $response->setData(
            \array_filter(
                \array_replace(
                    \array_fill_keys($keys, null),
                    \array_intersect_key((array) $response->getData(), \array_flip($keys)),
                ),
            ),
        );
    }
}

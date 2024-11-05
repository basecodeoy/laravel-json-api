<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

final class ResourceCollection implements MemberInterface
{
    /**
     * @var ResourceObject[]
     */
    private readonly array $resources;

    public function __construct(ResourceObject ...$resources)
    {
        $this->resources = $resources;
    }

    public function attachTo(array $data): array
    {
        $data['data'] = [];

        foreach ($this->resources as $resource) {
            $data = $resource->attachToCollection($data);
        }

        return $data;
    }
}

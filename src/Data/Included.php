<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

use LogicException;

final class Included implements MemberInterface
{
    /**
     * @var ResourceObject[]
     */
    private array $resources;

    public function __construct(ResourceObject ...$resources)
    {
        foreach ($resources as $resource) {
            $key = $resource->key();

            if (isset($this->resources[$key])) {
                throw new LogicException("Resource {$resource} is already included");
            }

            $this->resources[$key] = $resource;
        }
    }

    public function attachTo(array $data): array
    {
        foreach ($this->resources as $resource) {
            $data = $resource->attachAsIncludedTo($data);
        }

        return $data;
    }
}

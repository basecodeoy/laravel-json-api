<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

final class ResourceIdentifierCollection implements MemberInterface
{
    /**
     * @var ResourceIdentifier[]
     */
    private readonly array $identifiers;

    public function __construct(ResourceIdentifier ...$identifiers)
    {
        $this->identifiers = $identifiers;
    }

    public function attachTo(array $data): array
    {
        $data['data'] = [];

        foreach ($this->identifiers as $identifier) {
            $data = $identifier->attachToCollection($data);
        }

        return $data;
    }
}

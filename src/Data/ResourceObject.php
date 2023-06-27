<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

final class ResourceObject extends AbstractResourceObject implements MemberInterface
{
    public function __construct(string $type, private readonly string $id, MemberInterface ...$members)
    {
        parent::__construct($type, ...$members);
        $this->data['id'] = $id;
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->key();
    }

    public function identifier(): ResourceIdentifier
    {
        return new ResourceIdentifier($this->type, $this->id);
    }

    public function key(): string
    {
        return "{$this->type}:{$this->id}";
    }

    public function attachTo(array $data): array
    {
        $data['data'] = $this->data;

        return $data;
    }

    public function attachAsIncludedTo(array $data): array
    {
        $data['included'][] = $this->data;

        return $data;
    }

    public function attachToCollection(array $data): array
    {
        $data['data'][] = $this->data;

        return $data;
    }
}

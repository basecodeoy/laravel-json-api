<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

final class ResourceIdentifier implements MemberInterface
{
    private array $data;

    public function __construct(string $type, string $id, Meta ...$metas)
    {
        $this->data = [
            'type' => $type,
            'id' => $id,
        ];

        foreach ($metas as $meta) {
            $this->data = $meta->attachTo($this->data);
        }
    }

    public function attachTo(array $data): array
    {
        $data['data'] = $this->data;

        return $data;
    }

    public function attachToCollection(array $data): array
    {
        $data['data'][] = $this->data;

        return $data;
    }
}

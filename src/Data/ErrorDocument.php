<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

use JsonSerializable;

final class ErrorDocument implements HasMembersInterface, JsonSerializable
{
    use HasMembersTrait;

    public function __construct(
        private readonly ErrorObjectCollection $errors,
        private int $statusCode = 422,
    ) {
        //
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray(): array
    {
        return [
            ...$this->attachMembers(),
            'errors' => $this->errors->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

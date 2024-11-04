<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use JsonSerializable;

/**
 * @see https://jsonapi.org/format/#error-objects
 */
final class ErrorObjectLinks implements JsonSerializable
{
    public function __construct(
        private array|string|null $about = null,
        private array|string|null $type = null,
    ) {
        //
    }

    public function getAbout(): array|string|null
    {
        return $this->about;
    }

    public function setAbout(array|string|null $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getType(): array|string|null
    {
        return $this->type;
    }

    public function setType(array|string|null $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        return \array_filter([
            'about' => $this->about,
            'type' => $this->type,
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

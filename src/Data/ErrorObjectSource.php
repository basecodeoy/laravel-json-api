<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Data;

use JsonSerializable;

/**
 * @see https://jsonapi.org/format/#error-objects
 */
final class ErrorObjectSource implements JsonSerializable
{
    public function __construct(
        private ?string $pointer = null,
        private ?string $parameter = null,
        private ?string $header = null,
    ) {
        //
    }

    public function getPointer(): ?string
    {
        return $this->pointer;
    }

    public function setPointer(string $pointer): self
    {
        $this->pointer = $pointer;

        return $this;
    }

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function toArray(): array
    {
        return \array_filter([
            'pointer' => $this->pointer,
            'parameter' => $this->parameter,
            'header' => $this->header,
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

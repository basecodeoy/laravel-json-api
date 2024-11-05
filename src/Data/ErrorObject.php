<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Data;

use JsonSerializable;

/**
 * @see https://jsonapi.org/format/#error-objects
 */
final class ErrorObject implements JsonSerializable
{
    public function __construct(
        private ?string $id = null,
        private ?ErrorObjectLinks $links = null,
        private ?string $status = null,
        private ?string $code = null,
        private ?string $title = null,
        private ?string $detail = null,
        private ?ErrorObjectSource $source = null,
        private ?array $meta = null,
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLinks(): ?ErrorObjectLinks
    {
        return $this->links;
    }

    public function setLinks(ErrorObjectLinks $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(int|string $status): self
    {
        $this->status = (string) $status;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getSource(): ?ErrorObjectSource
    {
        return $this->source;
    }

    public function setSource(ErrorObjectSource $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'links' => $this->links?->toArray(),
            'status' => $this->status,
            'code' => $this->code,
            'title' => $this->title,
            'detail' => $this->detail,
            'source' => $this->source?->toArray(),
            'meta' => $this->meta,
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Resource\Concerns;

trait InteractsWithQueryBuilder
{
    private array $allowedFields = [];

    private array $allowedIncludes = [];

    public function setAllowedFields(array $fields): void
    {
        $this->allowedFields = $fields;
    }

    public function setAllowedIncludes(array $includes): void
    {
        $this->allowedIncludes = $includes;
    }
}

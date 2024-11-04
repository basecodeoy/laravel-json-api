<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Route;

use Illuminate\Database\Eloquent\Model;

interface RouterInterface
{
    public function getApiVersion(): string;

    public function getResourceType(): string;

    public function getResourceName(): ?string;

    public function hasResourceName(): bool;

    public function getResourceRelationship(): ?string;

    public function hasResourceRelationship(): bool;

    public function getModel(): Model;
}

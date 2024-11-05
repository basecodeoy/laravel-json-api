<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Entity\Relations;

use Illuminate\Support\Str;

abstract class AbstractRelation implements RelationInterface
{
    public function __construct(private readonly string $name) {}

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethodName(): string
    {
        return Str::camel(class_basename(static::class));
    }

    public function isToOne(): bool
    {
        return \in_array(class_basename(static::class), [
            'BelongsTo',
            'HasOne',
            'HasOneThrough',
            'MorphOne',
            'MorphTo',
        ], true);
    }

    public function isToMany(): bool
    {
        return \in_array(class_basename(static::class), [
            'BelongsToMany',
            'HasMany',
            'HasManyThrough',
            'MorphMany',
            'MorphToMany',
        ], true);
    }
}

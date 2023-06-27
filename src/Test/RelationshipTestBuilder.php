<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Test;

use Illuminate\Database\Eloquent\Model;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

final class RelationshipTestBuilder
{
    public function __construct(private readonly string $version) {}

    public static function make(string $version): self
    {
        return new self($version);
    }

    public function index(string $resource, string $relation): ResourceTestResponse
    {
        return new ResourceTestResponse(get(route("api.{$this->version}.{$resource}.{$relation}.index")));
    }

    public function store(string $resource, Model $model, string $relation, array|int|string $ids): ResourceTestResponse
    {
        return new ResourceTestResponse(
            post(
                route("api.{$this->version}.{$resource}.{$relation}.store", $model),
                [
                    'data' => \is_array($ids) ? \array_map(
                        fn (int $id) => ['type' => $relation, 'id' => $id],
                        $ids,
                    ) : ['type' => $relation, 'id' => $ids],
                ],
            ),
        );
    }

    public function show(string $resource, Model $model, string $relation): ResourceTestResponse
    {
        return new ResourceTestResponse(get(route("api.{$this->version}.{$resource}.{$relation}.show", $model)));
    }

    public function update(string $resource, Model $model, string $relation, array|int|string $ids): ResourceTestResponse
    {
        return new ResourceTestResponse(
            patch(
                route("api.{$this->version}.{$resource}.{$relation}.update", $model),
                [
                    'data' => \is_array($ids) ? \array_map(
                        fn (int $id) => ['type' => $relation, 'id' => $id],
                        $ids,
                    ) : ['type' => $relation, 'id' => $ids],
                ],
            ),
        );
    }

    public function delete(string $resource, Model $model, string $relation, array|int|string $ids): ResourceTestResponse
    {
        return new ResourceTestResponse(
            delete(
                route(
                    "api.{$this->version}.{$resource}.{$relation}.destroy",
                    $model,
                ),
                [
                    'data' => \is_array($ids) ? \array_map(
                        fn (int $id) => ['type' => $relation, 'id' => $id],
                        $ids,
                    ) : ['type' => $relation, 'id' => $ids],
                ],
            ),
        );
    }
}

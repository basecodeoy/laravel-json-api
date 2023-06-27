<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Test;

use Illuminate\Database\Eloquent\Model;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

final class ResourceTestBuilder
{
    public function __construct(private readonly string $version) {}

    public static function make(string $version): self
    {
        return new self($version);
    }

    public function index(string $resource): ResourceTestResponse
    {
        return new ResourceTestResponse(get(route("api.{$this->version}.{$resource}.index")));
    }

    public function store(string $resource, array $data, array $relationships = []): ResourceTestResponse
    {
        return new ResourceTestResponse(
            post(
                route("api.{$this->version}.{$resource}.store"),
                [
                    'data' => [
                        'type' => $resource,
                        'attributes' => $data,
                        'relationships' => $relationships,
                    ],
                ],
            ),
        );
    }

    public function show(string $resource, Model $model): ResourceTestResponse
    {
        return new ResourceTestResponse(get(route("api.{$this->version}.{$resource}.show", $model)));
    }

    public function update(string $resource, Model $model, array $data, array $relationships = []): ResourceTestResponse
    {
        return new ResourceTestResponse(
            patch(
                route("api.{$this->version}.{$resource}.update", $model),
                [
                    'data' => [
                        'type' => $model->getTable(),
                        'id' => $model->getKey(),
                        'attributes' => $data,
                        'relationships' => $relationships,
                    ],
                ],
            ),
        );
    }

    public function delete(string $resource, Model $model): ResourceTestResponse
    {
        return new ResourceTestResponse(delete(route("api.{$this->version}.{$resource}.destroy", $model)));
    }
}

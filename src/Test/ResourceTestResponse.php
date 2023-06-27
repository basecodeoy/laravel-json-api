<?php

declare(strict_types=1);

namespace BombenProdukt\JsonApi\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Testing\TestResponse as Illuminate;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

/**
 * @mixin \Illuminate\Testing\TestResponse
 */
final class ResourceTestResponse
{
    use ForwardsCalls;

    public function __construct(private readonly Illuminate $response) {}

    public function __call(string $name, array $arguments)
    {
        return $this->forwardCallTo($this->response, $name, $arguments);
    }

    public function toBePaginated(array $data = []): self
    {
        $this->assertStatus(200);
        $this->assertJsonStructure([
            'jsonapi' => [
                'version',
            ],
            'links' => [
                'first',
                'last',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);

        return $this;
    }

    public function toBePresent(Model $model, array $data): self
    {
        $this->assertStatus(200);

        assertDatabaseHas($model->getTable(), [
            ...$data,
            'id' => $model->id,
        ]);

        return $this;
    }

    public function toBeCreated(Model $model, array $data): self
    {
        $this->assertStatus(201);

        assertDatabaseHas($model->getTable(), $data);

        return $this;
    }

    public function toBeMissing(Model $model): self
    {
        $this->assertStatus(204);

        assertDatabaseMissing($model->getTable(), ['id' => $model->id]);

        return $this;
    }

    public function toBeResource(Model $model, array $attributes): self
    {
        $this->assertJson([
            'jsonapi' => [
                'version' => '1.1',
            ],
            'links' => [
                'self' => 'http://localhost/v1/users/1',
            ],
            'data' => [
                'type' => $model->getTable(),
                'id' => $model->getKey(),
                'attributes' => Arr::only($model->toArray(), $attributes),
                'links' => [
                    'self' => "http://localhost/v1/{$model->getTable()}/1",
                ],
            ],
        ]);

        return $this;
    }

    public function toBeUnprocessableContent(array $data): self
    {
        $this->assertStatus(422);

        $this->assertJson(['errors' => $data]);

        return $this;
    }
}

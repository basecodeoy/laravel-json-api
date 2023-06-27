<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use BombenProdukt\JsonApi\Test\ResourceTestBuilder;
use Tests\Models\User;
use function Pest\Laravel\assertDatabaseHas;

it('should return a list of users', function (): void {
    ResourceTestBuilder::make('v1')
        ->index('users')
        ->toBePaginated();
});

it('should store a new user', function (): void {
    $user = User::factory()->make();

    ResourceTestBuilder::make('v1')
        ->store('users', [
            'name' => 'John Doe',
            'email' => $email = fake()->safeEmail(),
            'email_verified_at' => now()->toString(),
            'password' => 'password',
        ])
        ->toBeCreated($user, ['email' => $email]);
});

it('should fail to store a new user', function (): void {
    ResourceTestBuilder::make('v1')
        ->store('users', [
            'name' => 'John Doe',
            'email' => 'invalid',
            'email_verified_at' => now()->toString(),
            'password' => 'password',
        ])
        ->toBeUnprocessableContent([
            [
                'status' => '422',
                'detail' => 'The data.attributes.email field must be a valid email address.',
                'source' => [
                    'pointer' => '/data/attributes/email',
                ],
            ],
        ]);
});

it('should show a user', function (): void {
    $user = User::factory()->create();

    ResourceTestBuilder::make('v1')
        ->show('users', $user)
        ->toBeResource($user, ['name']);
});

it('should update a user', function (): void {
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    assertDatabaseHas($user->getTable(), ['id' => $user->id]);

    ResourceTestBuilder::make('v1')
        ->update('users', $user, ['name' => 'Jane Doe'])
        ->toBePresent($user, ['name' => 'Jane Doe']);
});

it('should delete a user', function (): void {
    $user = User::factory()->create();

    assertDatabaseHas($user->getTable(), ['id' => $user->id]);

    ResourceTestBuilder::make('v1')
        ->delete('users', $user)
        ->toBeMissing($user);
});

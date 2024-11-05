<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\JsonApi\Server\Server;
use Tests\Models\Image;
use Tests\Models\Post;
use Tests\Models\Role;
use Tests\Models\Tag;
use Tests\Models\User;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->beforeEach(function (): void {
    // Configuration
    $this->app['config']->set('database.default', 'testbench');
    $this->app['config']->set('database.connections.testbench', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    // Dummy
    Schema::dropIfExists('comments');
    Schema::dropIfExists('posts');
    Schema::dropIfExists('users');

    Schema::create('users', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('roles', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('role_user', function (Blueprint $table): void {
        $table->id();
        $table->foreignIdFor(User::class);
        $table->foreignIdFor(Role::class);
        $table->timestamps();
    });

    Schema::create('posts', function (Blueprint $table): void {
        $table->id();
        $table->foreignIdFor(User::class);
        $table->foreignIdFor(Image::class)->nullable();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('images', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('tags', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('taggables', function (Blueprint $table): void {
        $table->id();
        $table->foreignIdFor(Tag::class);
        $table->morphs('taggable');
        $table->timestamps();
    });

    Schema::create('comments', function (Blueprint $table): void {
        $table->id();
        $table->foreignIdFor(User::class);
        $table->foreignIdFor(Post::class);
        $table->string('name');
        $table->timestamps();
    });

    // Dummy Server
    Config::set('json-api.namespace_json-api', 'Tests\\JsonApi');
    Config::set('json-api.namespace_model', 'Tests\\Models');
    Config::set('json-api.servers', [Server::class]);

    Route::jsonapi(Server::class)->discover();
})->in('Feature');

uses(
    Tests\TestCase::class,
)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeJsonSerialized', function (array|string $expected): void {
    expect(\json_decode(\json_encode($this->value->jsonSerialize()), true))->toBe($expected);
});

expect()->extend('toMatchJsonSerialized', function (): void {
    expect($this->value->jsonSerialize())->toMatchJsonSnapshot();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something(): void
{
    // ..
}

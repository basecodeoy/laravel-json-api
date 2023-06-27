<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use BombenProdukt\JsonApi\Test\RelationshipTestBuilder;
use Tests\Models\Image;
use Tests\Models\Post;
use Tests\Models\Tag;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\withoutExceptionHandling;

it('should attach tags (To-Many)', function (): void {
    $post = Post::factory()->create();
    $post->tags()->attach($existing = Tag::factory()->create());
    $tag = Tag::factory()->create();

    RelationshipTestBuilder::make('v1')
        ->store('posts', $post, 'tags', [$tag->id])
        ->assertNoContent();

    assertDatabaseHas('taggables', [
        'tag_id' => $existing->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);

    assertDatabaseHas('taggables', [
        'tag_id' => $tag->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);
});

it('should update the image (To-One)', function (): void {
    withoutExceptionHandling();

    $post = Post::factory()->create();
    $image = Image::factory()->create();

    RelationshipTestBuilder::make('v1')
        ->update('posts', $post, 'image', $image->id)
        ->assertNoContent();

    assertDatabaseHas('posts', [
        'image_id' => $image->getKey(),
    ]);
});

it('should update tags (To-Many)', function (): void {
    $post = Post::factory()->create();
    $post->tags()->attach($existing = Tag::factory()->create());
    $tag = Tag::factory()->create();

    RelationshipTestBuilder::make('v1')
        ->update('posts', $post, 'tags', [$tag->id])
        ->assertNoContent();

    assertDatabaseMissing('taggables', [
        'tag_id' => $existing->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);

    assertDatabaseHas('taggables', [
        'tag_id' => $tag->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);
});

it('should detach tags (To-Many)', function (): void {
    $post = Post::factory()->create();
    $post->tags()->attach($keep = Tag::factory()->create());
    $post->tags()->attach($detach = Tag::factory()->create());

    RelationshipTestBuilder::make('v1')
        ->delete('posts', $post, 'tags', [$detach->id])
        ->assertNoContent();

    assertDatabaseHas('taggables', [
        'tag_id' => $keep->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);

    assertDatabaseMissing('taggables', [
        'tag_id' => $detach->getKey(),
        'taggable_id' => $post->getKey(),
        'taggable_type' => Post::class,
    ]);
});

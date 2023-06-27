<?php

declare(strict_types=1);

namespace Tests\Unit\Resource\Model;

use BombenProdukt\JsonApi\Resource\Model\Link;

it('can be serialized to json with all properties', function (): void {
    $link = new Link(
        key: 'test',
        href: 'https://example.com',
        title: 'Test title',
        describedby: 'Test description',
        meta: ['meta1' => 'value1', 'meta2' => 'value2'],
    );

    expect($link)->toBeJsonSerialized([
        'href' => 'https://example.com',
        'title' => 'Test title',
        'describedby' => 'Test description',
        'meta' => ['meta1' => 'value1', 'meta2' => 'value2'],
    ]);
});

it('can be serialized to json with only href', function (): void {
    $link = new Link(
        key: 'test',
        href: 'https://example.com',
    );

    expect($link)->toBeJsonSerialized('https://example.com');
});

it('can create self link', function (): void {
    $link = Link::self(
        href: 'https://example.com',
    );

    expect($link->key)->toBe('self');
    expect($link->href)->toBe('https://example.com');
});

it('can create related link', function (): void {
    $link = Link::related(
        href: 'https://example.com',
    );

    expect($link->key)->toBe('related');
    expect($link->href)->toBe('https://example.com');
});

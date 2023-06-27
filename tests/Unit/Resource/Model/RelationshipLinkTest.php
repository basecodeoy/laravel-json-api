<?php

declare(strict_types=1);

namespace Tests\Unit\Resource\Model;

use BombenProdukt\JsonApi\Resource\Model\Link;
use BombenProdukt\JsonApi\Resource\Model\RelationshipLink;
use BombenProdukt\JsonApi\Resource\Model\ResourceIdentifier;

it('creates toOne relationship', function (): void {
    $identifier = new ResourceIdentifier('test', '1');
    $link = RelationshipLink::toOne($identifier);

    expect($link)->toBeInstanceOf(RelationshipLink::class);
    expect($link->jsonSerialize()['data'])->toBe($identifier);
});

it('creates toMany relationship', function (): void {
    $identifiers = [
        new ResourceIdentifier('test', '1'),
        new ResourceIdentifier('test', '2'),
    ];

    $link = RelationshipLink::toMany($identifiers);

    expect($link)->toBeInstanceOf(RelationshipLink::class);
    expect($link->jsonSerialize()['data'])->toBe($identifiers);
});

it('creates links and meta in the relationship', function (): void {
    $identifier = new ResourceIdentifier('test', '1');
    $links = [Link::self('http://example.com')];
    $meta = ['key' => 'value'];

    $link = RelationshipLink::toOne($identifier, $links, $meta);

    expect($link)->toBeInstanceOf(RelationshipLink::class);
    expect($link->jsonSerialize()['links'])->toBe(['self' => $links[0]]);
    expect($link->jsonSerialize()['meta'])->toBe($meta);
});

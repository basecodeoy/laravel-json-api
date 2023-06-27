<?php

declare(strict_types=1);

namespace Tests\Unit\Resource\Model;

use BombenProdukt\JsonApi\Resource\Model\RelationshipLink;
use BombenProdukt\JsonApi\Resource\Model\ResourceIdentifier;

it('serializes toOne relationship with ResourceIdentifier', function (): void {
    $link = RelationshipLink::toOne(new ResourceIdentifier('test', '1'));

    expect($link)->toBeJsonSerialized([
        'data' => [
            'type' => 'test',
            'id' => '1',
        ],
    ]);
});

it('serializes toMany relationship with ResourceIdentifiers', function (): void {
    $link = RelationshipLink::toMany([
        new ResourceIdentifier('test', '1'),
        new ResourceIdentifier('test', '2'),
    ]);

    expect($link)->toBeJsonSerialized([
        'data' => [
            [
                'type' => 'test',
                'id' => '1',
            ],
            [
                'type' => 'test',
                'id' => '2',
            ],
        ],
    ]);
});

it('serializes toOne relationship with ResourceIdentifier and meta', function (): void {
    $link = RelationshipLink::toOne(new ResourceIdentifier('test', '1', ['foo' => 'bar']));

    expect($link)->toBeJsonSerialized([
        'data' => [
            'type' => 'test',
            'id' => '1',
            'meta' => ['foo' => 'bar'],
        ],
    ]);
});

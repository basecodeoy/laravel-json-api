<?php

declare(strict_types=1);

namespace Tests\Unit\Resource\Model;

use BaseCodeOy\JsonApi\Resource\Model\Implementation;

it('can be serialized to json', function (): void {
    $implementation = new Implementation(
        version: '1.0',
        ext: ['ext1', 'ext2'],
        profile: ['profile1', 'profile2'],
        meta: ['meta1' => 'value1', 'meta2' => 'value2'],
    );

    $expectedArray = [
        'version' => '1.0',
        'ext' => ['ext1', 'ext2'],
        'profile' => ['profile1', 'profile2'],
        'meta' => ['meta1' => 'value1', 'meta2' => 'value2'],
    ];

    expect($implementation)->toBeJsonSerialized($expectedArray);
});

it('can be serialized to json with only version', function (): void {
    $implementation = new Implementation(
        version: '1.0',
    );

    $expectedArray = [
        'version' => '1.0',
    ];

    expect($implementation)->toBeJsonSerialized($expectedArray);
});

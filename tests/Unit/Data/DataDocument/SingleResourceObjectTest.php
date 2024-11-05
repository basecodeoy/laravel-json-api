<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\Attribute;
use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\JsonApi;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\ResourceObject;
use BaseCodeOy\JsonApi\Data\SelfLink;

it('tests minimal document', function (): void {
    expect(
        new DataDocument(
            new ResourceObject('apples', '1'),
        ),
    )->toMatchJsonSerialized();
});

it('tests extended document', function (): void {
    expect(
        new DataDocument(
            new ResourceObject(
                'apples',
                '1',
                new Attribute('color', 'red'),
                new Attribute('sort', 'Fuji'),
                new Meta('apple_meta', 'foo'),
            ),
            new SelfLink('/apples/1'),
            new JsonApi(),
            new Meta('document_meta', 'bar'),
        ),
    )->toMatchJsonSerialized();
});

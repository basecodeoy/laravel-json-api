<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\Attribute;
use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\ResourceObject;
use BombenProdukt\JsonApi\Data\SelfLink;

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

<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\ResourceIdentifierCollection;
use BombenProdukt\JsonApi\Data\SelfLink;

it('tests minimal document', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifierCollection(),
        ),
    )->toMatchJsonSerialized();
});

it('tests extended document', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifierCollection(
                new ResourceIdentifier(
                    'apples',
                    '1',
                    new Meta('apple_meta', 'foo'),
                ),
                new ResourceIdentifier(
                    'apples',
                    '2',
                    new Meta('apple_meta', 'foo'),
                ),
            ),
            new SelfLink('/apples'),
            new JsonApi(),
            new Meta('document_meta', 'bar'),
        ),
    )->toMatchJsonSerialized();
});

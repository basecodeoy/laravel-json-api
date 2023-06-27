<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\RelatedLink;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\SelfLink;

it('tests minimal document', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifier('companies', '1'),
        ),
    )->toMatchJsonSerialized();
});

it('tests extended document', function (): void {
    expect(
        new DataDocument(
            new ResourceIdentifier(
                'companies',
                '1',
                new Meta('apple_meta', 'foo'),
                new Meta('bar', [42]),
            ),
            new SelfLink('/books/123/relationships/publisher'),
            new RelatedLink('/books/123/publisher'),
            new JsonApi(),
            new Meta('document_meta', 'bar'),
        ),
    )->toMatchJsonSerialized();
});

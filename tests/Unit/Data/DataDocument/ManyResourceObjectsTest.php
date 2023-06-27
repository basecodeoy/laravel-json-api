<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\Attribute;
use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\JsonApi;
use BombenProdukt\JsonApi\Data\Meta;
use BombenProdukt\JsonApi\Data\RelatedLink;
use BombenProdukt\JsonApi\Data\ResourceCollection;
use BombenProdukt\JsonApi\Data\ResourceObject;
use BombenProdukt\JsonApi\Data\SelfLink;

it('tests minimal document', function (): void {
    expect(
        new DataDocument(
            new ResourceCollection(),
        ),
    )->toMatchJsonSerialized();
});

it('tests extended document', function (): void {
    expect(
        new DataDocument(
            new ResourceCollection(
                new ResourceObject(
                    'people',
                    '1',
                    new Attribute('name', 'Martin Fowler'),
                    new Meta('apple_meta', 'foo'),
                ),
                new ResourceObject(
                    'people',
                    '2',
                    new Attribute('name', 'Kent Beck'),
                    new Meta('apple_meta', 'foo'),
                ),
            ),
            new SelfLink('/books/123/relationships/authors'),
            new RelatedLink('/books/123/authors'),
            new JsonApi(),
            new Meta('document_meta', 'bar'),
        ),
    )->toMatchJsonSerialized();
});

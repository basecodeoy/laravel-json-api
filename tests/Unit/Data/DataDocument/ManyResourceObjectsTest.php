<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\Attribute;
use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\JsonApi;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\RelatedLink;
use BaseCodeOy\JsonApi\Data\ResourceCollection;
use BaseCodeOy\JsonApi\Data\ResourceObject;
use BaseCodeOy\JsonApi\Data\SelfLink;

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

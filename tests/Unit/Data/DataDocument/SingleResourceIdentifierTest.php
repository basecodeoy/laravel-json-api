<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\JsonApi;
use BaseCodeOy\JsonApi\Data\Meta;
use BaseCodeOy\JsonApi\Data\RelatedLink;
use BaseCodeOy\JsonApi\Data\ResourceIdentifier;
use BaseCodeOy\JsonApi\Data\SelfLink;

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

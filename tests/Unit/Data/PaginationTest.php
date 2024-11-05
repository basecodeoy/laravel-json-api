<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BaseCodeOy\JsonApi\Data\Attribute;
use BaseCodeOy\JsonApi\Data\CompoundDocument;
use BaseCodeOy\JsonApi\Data\DataDocument;
use BaseCodeOy\JsonApi\Data\FirstLink;
use BaseCodeOy\JsonApi\Data\Included;
use BaseCodeOy\JsonApi\Data\LastLink;
use BaseCodeOy\JsonApi\Data\NextLink;
use BaseCodeOy\JsonApi\Data\PaginatedCollection;
use BaseCodeOy\JsonApi\Data\Pagination;
use BaseCodeOy\JsonApi\Data\PrevLink;
use BaseCodeOy\JsonApi\Data\ResourceCollection;
use BaseCodeOy\JsonApi\Data\ResourceIdentifier;
use BaseCodeOy\JsonApi\Data\ResourceIdentifierCollection;
use BaseCodeOy\JsonApi\Data\ResourceObject;
use BaseCodeOy\JsonApi\Data\SelfLink;
use BaseCodeOy\JsonApi\Data\ToMany;

it('tests paginated resource collection', function (): void {
    expect(
        new DataDocument(
            new PaginatedCollection(
                new Pagination(
                    new FirstLink('http://example.com/fruits?page=first'),
                    new PrevLink('http://example.com/fruits?page=3'),
                    new NextLink('http://example.com/fruits?page=5'),
                    new LastLink('http://example.com/fruits?page=last'),
                ),
                new ResourceCollection(
                    new ResourceObject('apples', '1'),
                    new ResourceObject('apples', '2'),
                ),
            ),
            new SelfLink('http://example.com/fruits?page=4'),
        ),
    )->toMatchJsonSerialized();
});

it('tests paginated resource identifier collection', function (): void {
    expect(
        new CompoundDocument(
            new ResourceObject(
                'baskets',
                '1',
                new ToMany(
                    'fruits',
                    new ResourceIdentifierCollection(
                        new ResourceIdentifier('apples', '1'),
                        new ResourceIdentifier('apples', '2'),
                    ),
                    new Pagination(
                        new FirstLink('http://example.com/basket/1/fruits?page=first'),
                        new PrevLink('http://example.com/basket/1/fruits?page=3'),
                        new NextLink('http://example.com/basket/1/fruits?page=5'),
                        new LastLink('http://example.com/basket/1/fruits?page=last'),
                    ),
                ),
            ),
            new Included(
                new ResourceObject('apples', '1', new Attribute('color', 'red')),
                new ResourceObject('apples', '2', new Attribute('color', 'yellow')),
            ),
        ),
    )->toMatchJsonSerialized();
});

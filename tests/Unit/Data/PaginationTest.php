<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\Attribute;
use BombenProdukt\JsonApi\Data\CompoundDocument;
use BombenProdukt\JsonApi\Data\DataDocument;
use BombenProdukt\JsonApi\Data\FirstLink;
use BombenProdukt\JsonApi\Data\Included;
use BombenProdukt\JsonApi\Data\LastLink;
use BombenProdukt\JsonApi\Data\NextLink;
use BombenProdukt\JsonApi\Data\PaginatedCollection;
use BombenProdukt\JsonApi\Data\Pagination;
use BombenProdukt\JsonApi\Data\PrevLink;
use BombenProdukt\JsonApi\Data\ResourceCollection;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\ResourceIdentifierCollection;
use BombenProdukt\JsonApi\Data\ResourceObject;
use BombenProdukt\JsonApi\Data\SelfLink;
use BombenProdukt\JsonApi\Data\ToMany;

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

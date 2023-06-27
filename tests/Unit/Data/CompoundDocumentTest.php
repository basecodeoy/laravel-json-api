<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use BombenProdukt\JsonApi\Data\Attribute;
use BombenProdukt\JsonApi\Data\CompoundDocument;
use BombenProdukt\JsonApi\Data\Included;
use BombenProdukt\JsonApi\Data\LastLink;
use BombenProdukt\JsonApi\Data\NextLink;
use BombenProdukt\JsonApi\Data\PaginatedCollection;
use BombenProdukt\JsonApi\Data\Pagination;
use BombenProdukt\JsonApi\Data\RelatedLink;
use BombenProdukt\JsonApi\Data\ResourceCollection;
use BombenProdukt\JsonApi\Data\ResourceIdentifier;
use BombenProdukt\JsonApi\Data\ResourceIdentifierCollection;
use BombenProdukt\JsonApi\Data\ResourceObject;
use BombenProdukt\JsonApi\Data\SelfLink;
use BombenProdukt\JsonApi\Data\ToMany;
use BombenProdukt\JsonApi\Data\ToOne;

it('tests official docs example', function (): void {
    $dan = new ResourceObject(
        'people',
        '9',
        new Attribute('first-name', 'Dan'),
        new Attribute('last-name', 'Gebhardt'),
        new Attribute('twitter', 'dgeb'),
        new SelfLink('http://example.com/people/9'),
    );

    $comment05 = new ResourceObject(
        'comments',
        '5',
        new Attribute('body', 'First!'),
        new SelfLink('http://example.com/comments/5'),
        new ToOne('author', new ResourceIdentifier('people', '2')),
    );

    $comment12 = new ResourceObject(
        'comments',
        '12',
        new Attribute('body', 'I like XML better'),
        new SelfLink('http://example.com/comments/12'),
        new ToOne('author', $dan->identifier()),
    );

    expect(
        new CompoundDocument(
            new PaginatedCollection(
                new Pagination(
                    new NextLink('http://example.com/articles?page[offset]=2'),
                    new LastLink('http://example.com/articles?page[offset]=10'),
                ),
                new ResourceCollection(
                    new ResourceObject(
                        'articles',
                        '1',
                        new Attribute('title', 'JSON API paints my bikeshed!'),
                        new SelfLink('http://example.com/articles/1'),
                        new ToOne(
                            'author',
                            $dan->identifier(),
                            new SelfLink('http://example.com/articles/1/relationships/author'),
                            new RelatedLink('http://example.com/articles/1/author'),
                        ),
                        new ToMany(
                            'comments',
                            new ResourceIdentifierCollection(
                                $comment05->identifier(),
                                $comment12->identifier(),
                            ),
                            new SelfLink('http://example.com/articles/1/relationships/comments'),
                            new RelatedLink('http://example.com/articles/1/comments'),
                        ),
                    ),
                ),
            ),
            new Included($dan, $comment05, $comment12),
            new SelfLink('http://example.com/articles'),
        ),
    )->toMatchJsonSerialized();
});

it('tests included resource may be identified by linkage in primary data', function (): void {
    $author = new ResourceObject('people', '9');
    $article = new ResourceObject(
        'articles',
        '1',
        new ToOne('author', $author->identifier()),
    );
    expect(new CompoundDocument($article, new Included($author)))->not()->toBeEmpty();
});

it('tests included resource may be identified by another linked resource', function (): void {
    $writer = new ResourceObject('writers', '3', new Attribute('name', 'Eric Evans'));
    $book = new ResourceObject(
        'books',
        '2',
        new Attribute('name', 'Domain Driven Design'),
        new ToOne('author', $writer->identifier()),
    );
    $cart = new ResourceObject(
        'shopping-carts',
        '1',
        new ToMany('contents', new ResourceIdentifierCollection($book->identifier())),
    );
    expect(new CompoundDocument($cart, new Included($book, $writer)))->not()->toBeEmpty();
});

it('tests can not be many included resources with equal identifiers', function (): void {
    $this->expectException('LogicException');
    $this->expectExceptionMessage('Resource apples:1 is already included');
    $apple = new ResourceObject('apples', '1');
    new CompoundDocument($apple->identifier(), new Included($apple, $apple));
});

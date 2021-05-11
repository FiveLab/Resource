<?php

declare(strict_types = 1);

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\Hateoas;

use FiveLab\Component\Resource\Resource\Action\Action;
use FiveLab\Component\Resource\Resource\Action\Method;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Resource\ResourceCollection;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\Serializer;
use FiveLab\Component\Resource\Serializers\Hateoas\HateoasSerializer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\PaginatedCollectionNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\ResourceCollectionNormalizer;
use FiveLab\Component\Resource\Tests\Resources\AddressResource;
use FiveLab\Component\Resource\Tests\Resources\CustomerResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class HateoasSerializerTest extends TestCase
{
    /**
     * @var HateoasSerializer
     */
    private HateoasSerializer $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $normalizers = [
            new PaginatedCollectionNormalizer(),
            new RelationCollectionNormalizer(),
            new RelationNormalizer(),
            new ResourceCollectionNormalizer(),
            new ObjectNormalizer(),
        ];

        $serializer = new Serializer($normalizers, [new JsonEncoder()]);
        $serializer->setEventDispatcher(new EventDispatcher());

        $this->serializer = new HateoasSerializer($serializer, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSerialize(): void
    {
        $resource = new CustomerResource(1, 'John', new AddressResource('UK', 'London'));
        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'id'      => 1,
            'name'    => 'John',
            'address' => [
                'country' => 'UK',
                'city'    => 'London',
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithLinks(): void
    {
        $resource = new CustomerResource(2, 'Smith', new AddressResource('UK'));
        $resource->addRelation(new Relation('self', new Href('/customers/2')));
        $resource->addAction(new Action('edit', new Href('/customers/2'), new Method('POST')));

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'id'      => 2,
            'name'    => 'Smith',
            'address' => [
                'country' => 'UK',
                'city'    => null,
            ],
            '_links'  => [
                'self' => ['href' => '/customers/2'],
                'edit' => ['href' => '/customers/2'],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithSpecificLinks(): void
    {
        $resource = new CustomerResource(2, 'Smith', new AddressResource('UK'));
        $resource->addRelation(new Relation('contact', new Href('/customers/{customer}', true), ['foo' => 'bar']));

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'contact' => [
                'href'       => '/customers/{customer}',
                'templated'  => true,
                'attributes' => ['foo' => 'bar'],
            ],
        ], \json_decode($serialized, true)['_links']);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollection(): void
    {
        $collection = new ResourceCollection(
            new CustomerResource(1, 'John', new AddressResource('UK')),
            new CustomerResource(2, 'Smith', new AddressResource('UA', 'Odessa'))
        );

        $serialized = $this->serializer->serialize($collection, new ResourceSerializationContext([]));

        self::assertEquals([
            [
                'id'      => 1,
                'name'    => 'John',
                'address' => ['country' => 'UK', 'city' => null],
            ],
            [
                'id'      => 2,
                'name'    => 'Smith',
                'address' => ['country' => 'UA', 'city' => 'Odessa'],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollectionWithLinks(): void
    {
        $collection = new ResourceCollection(
            new CustomerResource(1, 'John', new AddressResource('UK')),
            new CustomerResource(2, 'Smith', new AddressResource('UA', 'Odessa'))
        );

        $collection->addRelation(new Relation('self', new Href('/customers')));
        $collection->addAction(new Action('add', new Href('/customers/new'), new Method('POST')));

        $serialized = $this->serializer->serialize($collection, new ResourceSerializationContext([]));

        self::assertEquals([
            '_links'    => [
                'self' => ['href' => '/customers'],
                'add'  => ['href' => '/customers/new'],
            ],
            '_embedded' => [
                'items' => [
                    [
                        'id'      => 1,
                        'name'    => 'John',
                        'address' => ['country' => 'UK', 'city' => null],
                    ],
                    [
                        'id'      => 2,
                        'name'    => 'Smith',
                        'address' => ['country' => 'UA', 'city' => 'Odessa'],
                    ],
                ],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializePaginatedCollection(): void
    {
        $paginated = new PaginatedResourceCollection(
            2,
            2,
            20,
            new CustomerResource(1, 'John', new AddressResource('UK')),
            new CustomerResource(2, 'Smith', new AddressResource('UA', 'Odessa'))
        );

        $serialized = $this->serializer->serialize($paginated, new ResourceSerializationContext([]));

        self::assertEquals([
            'state'     => [
                'page'   => 2,
                'limit'  => 2,
                'total'  => 20,
                'pages'  => 10,
                '_links' => [],
            ],
            '_embedded' => [
                'items' => [
                    [
                        'id'      => 1,
                        'name'    => 'John',
                        'address' => ['country' => 'UK', 'city' => null],
                    ],
                    [
                        'id'      => 2,
                        'name'    => 'Smith',
                        'address' => ['country' => 'UA', 'city' => 'Odessa'],
                    ],
                ],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldThrowErrorOnDeserialization(): void
    {
        $this->expectException(DeserializationNotSupportException::class);
        $this->expectExceptionMessage('The hateoas not support deserialization.');

        $this->serializer->deserialize('{}', CustomerResource::class, new ResourceSerializationContext([]));
    }
}

<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\WebApi;

use FiveLab\Component\Resource\Resource\Action\Action;
use FiveLab\Component\Resource\Resource\Action\Method;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Resource\ResourceCollection;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Serializer;
use FiveLab\Component\Resource\Serializers\WebApi\Normalizer\PaginatedCollectionNormalizer;
use FiveLab\Component\Resource\Serializers\WebApi\WebApiSerializer;
use FiveLab\Component\Resource\Tests\Resources\AddressResource;
use FiveLab\Component\Resource\Tests\Resources\CustomerResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class WebApiSerializerTest extends TestCase
{
    /**
     * @var WebApiSerializer
     */
    private WebApiSerializer $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $normalizers = [
            new PaginatedCollectionNormalizer(),
            new ObjectNormalizer(),
        ];

        $serializer = new Serializer($normalizers, [new JsonEncoder()]);
        $this->serializer = new WebApiSerializer($serializer, 'json', []);
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
        $resource = new CustomerResource(1, 'John', new AddressResource('UK', 'London'));
        $resource->addRelation(new Relation('self', new Href('/customers/1')));
        $resource->addAction(new Action('edit', new Href('/customer/1'), new Method('POST')));

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
    public function shouldSuccessSerializeCollection(): void
    {
        $collection = new ResourceCollection(
            new CustomerResource(1, 'John', new AddressResource('UK', 'London')),
            new CustomerResource(2, 'Smith', new AddressResource('UA'))
        );

        $serialized = $this->serializer->serialize($collection, new ResourceSerializationContext([]));

        self::assertEquals([
            [
                'id'      => 1,
                'name'    => 'John',
                'address' => [
                    'country' => 'UK',
                    'city'    => 'London',
                ],
            ],
            [
                'id'      => 2,
                'name'    => 'Smith',
                'address' => [
                    'country' => 'UA',
                    'city'    => null,
                ],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollectionWithLinks(): void
    {
        $collection = new ResourceCollection(
            new CustomerResource(1, 'John', new AddressResource('UK', 'London')),
            new CustomerResource(2, 'Smith', new AddressResource('UA'))
        );

        $collection->addRelation(new Relation('self', new Href('/customers')));

        $serialized = $this->serializer->serialize($collection, new ResourceSerializationContext([]));

        self::assertEquals([
            [
                'id'      => 1,
                'name'    => 'John',
                'address' => [
                    'country' => 'UK',
                    'city'    => 'London',
                ],
            ],
            [
                'id'      => 2,
                'name'    => 'Smith',
                'address' => [
                    'country' => 'UA',
                    'city'    => null,
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
            new CustomerResource(1, 'John', new AddressResource('UK', 'London')),
            new CustomerResource(2, 'Smith', new AddressResource('UA'))
        );

        $serialized = $this->serializer->serialize($paginated, new ResourceSerializationContext([]));

        self::assertEquals([
            'page'  => 2,
            'limit' => 2,
            'total' => 20,
            'items' => [
                [
                    'id'      => 1,
                    'name'    => 'John',
                    'address' => [
                        'country' => 'UK',
                        'city'    => 'London',
                    ],
                ],
                [
                    'id'      => 2,
                    'name'    => 'Smith',
                    'address' => [
                        'country' => 'UA',
                        'city'    => null,
                    ],
                ],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessDeserialize(): void
    {
        $object = $this->serializer->deserialize(\json_encode([
            'id'      => 1,
            'name'    => 'John',
            'address' => ['country' => 'UK'],
        ]), CustomerResource::class, new ResourceSerializationContext([]));

        self::assertEquals(new CustomerResource(1, 'John', new AddressResource('UK')), $object);
    }
}

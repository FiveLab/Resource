<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\VndError;

use FiveLab\Component\Resource\Resource\Action\Action;
use FiveLab\Component\Resource\Resource\Action\Method;
use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\Serializer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorCollectionNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorResourceNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\VndErrorSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class VndErrorSerializerTest extends TestCase
{
    /**
     * @var VndErrorSerializer
     */
    private VndErrorSerializer $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $normalizers = [
            new ErrorCollectionNormalizer(),
            new ErrorResourceNormalizer(),
            new RelationCollectionNormalizer(),
            new RelationNormalizer(),
        ];

        $serializer = new Serializer($normalizers, [new JsonEncoder()]);
        $this->serializer = new VndErrorSerializer($serializer, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSerialize(): void
    {
        $resource = new ErrorResource('Invalid data', 'InvalidData', 'foo.bar', [], 31);
        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'message' => 'Invalid data',
            'path'    => 'foo.bar',
            'logref'  => 31,
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithLinks(): void
    {
        $resource = new ErrorResource('Invalid data', 'InvalidData', 'foo.bar', [], 31);
        $resource->addRelation(new Relation('describe', new Href('/errors/31')));
        $resource->addAction(new Action('update', new Href('/fix/31'), new Method('POST')));

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'message' => 'Invalid data',
            'path'    => 'foo.bar',
            'logref'  => 31,
            '_links'  => [
                'describe' => ['href' => '/errors/31'],
                'update'   => ['href' => '/fix/31'],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollection(): void
    {
        $resource = new ErrorCollection(
            'Wrong data',
            'InvalidData'
        );

        $resource->addErrors(
            new ErrorResource('Invalid email', null, 'email'),
            new ErrorResource('Invalid phone', null, 'phone')
        );

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'message'   => 'Wrong data',
            '_embedded' => [
                'errors' => [
                    [
                        'message' => 'Invalid email',
                        'path'    => 'email',
                    ],
                    [
                        'message' => 'Invalid phone',
                        'path'    => 'phone',
                    ],
                ],
            ],
        ], \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollectionWithLinks(): void
    {
        $resource = new ErrorCollection(
            'Wrong data',
            'InvalidData'
        );

        $resource->addErrors(
            new ErrorResource('Invalid email', null, 'email'),
            new ErrorResource('Invalid phone', null, 'phone')
        );

        $resource->addRelation(new Relation('describe', new Href('/errors/foo')));
        $resource->addAction(new Action('fix', new Href('/errors/foo/fix'), Method::post()));

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'describe' => ['href' => '/errors/foo'],
            'fix'      => ['href' => '/errors/foo/fix'],
        ], \json_decode($serialized, true)['_links']);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeCollectionWithoutNested(): void
    {
        $resource = new ErrorCollection('');

        $resource->addErrors(
            new ErrorResource('Invalid email', null, 'email'),
            new ErrorResource('Invalid phone', null, 'phone')
        );

        $resource->addRelation(new Relation('describe', new Href('/errors/foo')));
        $resource->addAction(new Action('fix', new Href('/errors/foo/fix'), Method::post()));

        $serialized = $this->serializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals([
            'total'     => 2,
            '_links'    => [
                'describe' => ['href' => '/errors/foo'],
                'fix'      => ['href' => '/errors/foo/fix'],
            ],
            '_embedded' => [
                'errors' => [
                    [
                        'message' => 'Invalid email',
                        'path'    => 'email',
                    ],
                    [
                        'message' => 'Invalid phone',
                        'path'    => 'phone',
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
        $this->expectExceptionMessage('The Vnd.Error not support deserialization.');

        $this->serializer->deserialize('{}', ErrorResource::class, new ResourceSerializationContext([]));
    }
}

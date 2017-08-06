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

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionObjectNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationObjectNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorCollectionObjectNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorResourceObjectNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\VndErrorSerializer;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class VndErrorSerializerTest extends TestCase
{
    /**
     * @var SerializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serializer;

    /**
     * @var VndErrorSerializer
     */
    private $vndErrorSerializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->vndErrorSerializer = new VndErrorSerializer($this->serializer, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSerialize(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $this->serializer->expects(self::once())
            ->method('serialize')
            ->with($resource, 'json', [
                'normalizers' => [
                    new ErrorResourceObjectNormalizer(),
                    new ErrorCollectionObjectNormalizer(),
                    new RelationObjectNormalizer(),
                    new RelationCollectionObjectNormalizer(),
                ],
            ])
            ->willReturn('some-serialized');

        $serialized = $this->vndErrorSerializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals('some-serialized', $serialized);
    }

    /**
     * @test
     *
     * @expectedException \FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException
     * @expectedExceptionMessage The Vnd.Error not support deserialization.
     */
    public function shouldFailDeserialize(): void
    {
        $this->vndErrorSerializer->deserialize('some', ResourceInterface::class, new ResourceSerializationContext([]));
    }
}

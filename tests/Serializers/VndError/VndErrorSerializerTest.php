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
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\VndError\VndErrorSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
     * @var array|NormalizerInterface[]
     */
    private $normalizers;

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
        $this->normalizers = [$this->createMock(NormalizerInterface::class)];
        $this->vndErrorSerializer = new VndErrorSerializer($this->serializer, $this->normalizers, 'json');
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
                'normalizers' => $this->normalizers,
            ])
            ->willReturn('some-serialized');

        $serialized = $this->vndErrorSerializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals('some-serialized', $serialized);
    }

    /**
     * @test
     */
    public function shouldFailDeserialize(): void
    {
        $this->expectException(DeserializationNotSupportException::class);
        $this->expectExceptionMessage('The Vnd.Error not support deserialization.');

        $this->vndErrorSerializer->deserialize('some', ResourceInterface::class, new ResourceSerializationContext([]));
    }
}

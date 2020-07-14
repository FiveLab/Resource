<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\Hateoas;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\HateoasSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class HateoasSerializerTest extends TestCase
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
     * @var HateoasSerializer
     */
    private $hateoasSerializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->normalizers = [$this->createMock(NormalizerInterface::class)];
        $this->hateoasSerializer = new HateoasSerializer($this->serializer, $this->normalizers, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSerialize(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $this->serializer->expects(self::once())
            ->method('serialize')
            ->with($resource, 'json', self::callback(function ($context) {
                self::assertTrue(is_array($context), 'The context must be a array.');
                self::assertArrayHasKey('after_normalization', $context);
                self::assertArrayHasKey('normalizers', $context);

                self::assertEquals($this->normalizers, $context['normalizers']);

                return true;
            }))
            ->willReturnCallback(function (ResourceInterface $resource, $format, $context) {
                $data = [
                    'relations' => ['some-relation'],
                    'actions'   => ['some-actions'],
                ];

                return json_encode($context['after_normalization']($data));
            });

        $serialized = $this->hateoasSerializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals('{"_links":["some-relation","some-actions"]}', $serialized);
    }

    /**
     * @test
     */
    public function shouldFailDeserialize(): void
    {
        $this->expectException(DeserializationNotSupportException::class);
        $this->expectExceptionMessage('The hateoas not support deserialization.');

        $this->hateoasSerializer->deserialize('some-data', 'MyClass', new ResourceSerializationContext([]));
    }
}

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

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\WebApi\WebApiSerializer;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class WebApiSerializerTest extends TestCase
{
    /**
     * @var SerializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serializer;

    /**
     * @var WebApiSerializer
     */
    private $webApiSerializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->webApiSerializer = new WebApiSerializer($this->serializer, 'json');
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
                self::assertTrue(is_array($context), 'Context is not array.');
                self::assertArrayHasKey('after_normalization', $context);

                return true;
            }))
            ->willReturnCallback(function ($resource, $format, $context) {
                return json_encode($context['after_normalization']([
                    'relations' => ['some-foo-bar'],
                    'some'      => 'foo',
                ]));
            });

        $data = $this->webApiSerializer->serialize($resource, new ResourceSerializationContext([]));

        self::assertEquals('{"some":"foo"}', $data);
    }

    /**
     * @test
     */
    public function shouldSuccessDeserialize(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $this->serializer->expects(self::once())
            ->method('deserialize')
            ->with('custom data', 'SomeMyClass', 'json')
            ->willReturn($resource);

        $result = $this->webApiSerializer->deserialize('custom data', 'SomeMyClass', new ResourceSerializationContext([]));

        self::assertEquals($resource, $result);
    }
}

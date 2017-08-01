<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer;

use FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\BeforeNormalizationEvent;
use FiveLab\Component\Resource\Serializer\Normalizer\ObjectNormalizer;
use FiveLab\Component\Resource\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class SerializerTest extends TestCase
{
    /**
     * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $eventDispatcher;

    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    /**
     * @var JsonEncoder
     */
    private $jsonEncoder;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->objectNormalizer = new ObjectNormalizer();
        $this->jsonEncoder = new JsonEncoder();

        $this->serializer = new Serializer($this->eventDispatcher, [$this->objectNormalizer], [$this->jsonEncoder]);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithoutCustomNormalizer(): void
    {
        $data = $this->serializer->serialize(new TestedClassForSerialization(), 'json', []);

        self::assertEquals('{"field1":"field1","field2":["field2"]}', $data);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithCustomNormalizer(): void
    {
        $called = false;

        $context = [
            'normalizers' => [new CustomNormalizer(function () use (&$called) {
                $called = true;
            })]
        ];

        $data = $this->serializer->serialize(new TestedClassForSerialization(), 'json', $context);

        self::assertTrue($called, 'The custom normalizer not called.');
        self::assertEquals('["custom data"]', $data);
    }

    /**
     * @test
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage some foo bar
     */
    public function shouldSuccessCleanNormalizersAfterCatchException(): void
    {
        $context = [
            'normalizers' => [new CustomNormalizer(function () {
                throw new \RuntimeException('some foo bar');
            })]
        ];

        try {
            $this->serializer->serialize(new TestedClassForSerialization(), 'json', $context);
        } catch (\RuntimeException $e) {
            $normalizersRef = new \ReflectionProperty($this->serializer, 'normalizers');
            $normalizersRef->setAccessible(true);
            $normalizers = $normalizersRef->getValue($this->serializer);

            self::assertEquals([$this->objectNormalizer], $normalizers);

            throw $e;
        }

        self::fail('Should throw exception.');
    }

    /**
     * @test
     */
    public function shouldSuccessDispatchEvents(): void
    {
        $resource = new TestedClassForSerialization();

        $this->eventDispatcher->expects(self::at(0))
            ->method('dispatch')
            ->with(
                'fivelab.serializer.normalization.before',
                new BeforeNormalizationEvent($resource, 'json', [])
            );

        $this->eventDispatcher->expects(self::at(1))
            ->method('dispatch')
            ->with(
                'fivelab.serializer.normalization.after',
                new AfterNormalizationEvent($resource, ['field1' => 'field1', 'field2' => ['field2']], 'json', [])
            );

        $this->serializer->serialize($resource, 'json', []);
    }
}

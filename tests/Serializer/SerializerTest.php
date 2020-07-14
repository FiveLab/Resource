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

use FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\BeforeDenormalizationEvent;
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

        $this->serializer = new Serializer([$this->objectNormalizer], [$this->jsonEncoder], $this->eventDispatcher);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithoutCustomNormalizer(): void
    {
        $data = $this->serializer->serialize(new TestedClassForSerialization(), 'json', []);

        self::assertEquals('{"fieldFoo":"field1","fieldBar":["field2"]}', $data);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithCustomNormalizer(): void
    {
        $calledToNormalizer = false;
        $calledToDenormalizer = false;

        $context = [
            'normalizers' => [
                new CustomNormalizer(static function () use (&$calledToNormalizer) {
                    $calledToNormalizer = true;
                }),

                new CustomDenormalizer(static function () use (&$calledToDenormalizer) {
                    $calledToDenormalizer = true;
                }),
            ],
        ];

        $data = $this->serializer->serialize(new TestedClassForSerialization(), 'json', $context);

        self::assertTrue($calledToNormalizer, 'The custom normalizer not called.');
        self::assertFalse($calledToDenormalizer, 'Can\'t called to denormalized.');
        self::assertEquals('["custom data"]', $data);
    }

    /**
     * @test
     */
    public function shouldSuccessCleanNormalizersAfterCatchExceptionOnNormalization(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('some foo bar');

        $context = [
            'normalizers' => [
                new CustomNormalizer(static function () {
                    throw new \RuntimeException('some foo bar');
                }),
            ],
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
    public function shouldSuccessDispatchEventsOnNormalization(): void
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
                new AfterNormalizationEvent($resource, ['fieldFoo' => 'field1', 'fieldBar' => ['field2']], 'json', [])
            );

        $this->serializer->serialize($resource, 'json', []);
    }

    /**
     * @test
     */
    public function shouldSuccessDeserializeWithoutCustomDenormalizer(): void
    {
        $data = $this->serializer->deserialize('{"fieldFoo":"foo","fieldBar":["bar"]}', TestedClassForSerialization::class, 'json', []);

        self::assertEquals(new TestedClassForSerialization('foo', ['bar']), $data);
    }

    /**
     * @test
     */
    public function shouldSuccessDeserializeWithCustomDenormalizer(): void
    {
        $calledToNormalizer = false;
        $calledToDenormalizer = false;

        $context = [
            'normalizers' => [
                new CustomNormalizer(static function () use (&$calledToNormalizer) {
                    $calledToNormalizer = true;
                }),

                new CustomDenormalizer(static function () use (&$calledToDenormalizer) {
                    $calledToDenormalizer = true;
                }),
            ],
        ];

        $data = $this->serializer->deserialize('{"fieldFoo":"foo","fieldBar":["bar"]}', TestedClassForSerialization::class, 'json', $context);

        self::assertFalse($calledToNormalizer, 'Can\'t called to normalized.');
        self::assertTrue($calledToDenormalizer, 'The custom denormalizer not called.');
        self::assertEquals(new TestedClassForSerialization('denormalized', ['denormalized']), $data);
    }

    /**
     * @test
     */
    public function shouldSuccessCleanNormalizersAfterCatchExceptionOnDenormalization(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('some foo bar');

        $context = [
            'normalizers' => [
                new CustomDenormalizer(static function () {
                    throw new \RuntimeException('some foo bar');
                }),
            ],
        ];

        try {
            $this->serializer->deserialize('{}', TestedClassForSerialization::class, 'json', $context);
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
    public function shouldSuccessDispatchEventsOnDenormalization(): void
    {
        $this->eventDispatcher->expects(self::at(0))
            ->method('dispatch')
            ->with(
                'fivelab.serializer.denormalization.before',
                new BeforeDenormalizationEvent(['fieldFoo' => 'foo', 'fieldBar' => []], TestedClassForSerialization::class, 'json', [])
            );

        $this->eventDispatcher->expects(self::at(1))
            ->method('dispatch')
            ->with(
                'fivelab.serializer.denormalization.after',
                new AfterDenormalizationEvent(['fieldFoo' => 'foo', 'fieldBar' => []], new TestedClassForSerialization('foo', []), 'json', [])
            );

        $this->serializer->deserialize('{"fieldFoo": "foo", "fieldBar": []}', TestedClassForSerialization::class, 'json', []);
    }
}

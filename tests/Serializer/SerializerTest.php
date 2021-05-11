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
use FiveLab\Component\Resource\Serializer\SerializationEvents;
use FiveLab\Component\Resource\Serializer\Serializer;
use FiveLab\Component\Resource\Tests\Resources\AddressResource;
use FiveLab\Component\Resource\Tests\Resources\CustomerResource;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class SerializerTest extends TestCase
{
    /**
     * @var EventDispatcherInterface|MockObject
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @var Serializer
     */
    private Serializer $serializerWithoutEventDispatcher;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->serializerWithoutEventDispatcher = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->serializer->setEventDispatcher($this->eventDispatcher);
    }

    /**
     * @test
     */
    public function shouldSuccessSerialize(): void
    {
        $serialized = $this->serializer->serialize($this->makeExpectedResource(), 'json');

        self::assertEquals($this->makeExpectedSerializedArray(), \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializerWithoutEventDispatcher(): void
    {
        $serialized = $this->serializerWithoutEventDispatcher->serialize($this->makeExpectedResource(), 'json');

        self::assertEquals($this->makeExpectedSerializedArray(), \json_decode($serialized, true));
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithEventDispatching(): void
    {
        $resource = new CustomerResource(1, 'Smith', new AddressResource('UK'));
        $serializedResource = [
            'id'        => 1,
            'name'      => 'Smith',
            'address'   => [
                'country' => 'UK',
                'city'    => null,
            ],
            'actions'   => [],
            'relations' => [],
        ];

        $this->eventDispatcher->expects(self::exactly(4))
            ->method('dispatch')
            ->withConsecutive(
                [
                    self::callback(static function (BeforeNormalizationEvent $event) use ($resource) {
                        self::assertEquals($resource, $event->getResource());

                        return true;
                    }),
                    SerializationEvents::BEFORE_NORMALIZATION,
                ],
                [
                    self::callback(static function (BeforeNormalizationEvent $event) use ($resource) {
                        self::assertEquals($resource->address, $event->getResource());

                        return true;
                    }),

                    SerializationEvents::BEFORE_NORMALIZATION,
                ],
                [
                    self::callback(static function (AfterNormalizationEvent $event) use ($resource, $serializedResource) {
                        self::assertEquals($resource->address, $event->getResource());
                        self::assertEquals($serializedResource['address'], $event->getNormalizedData());

                        return true;
                    }),
                    SerializationEvents::AFTER_NORMALIZATION,
                ],
                [
                    self::callback(static function (AfterNormalizationEvent $event) use ($resource, $serializedResource) {
                        self::assertEquals($resource, $event->getResource());
                        self::assertEquals($serializedResource, $event->getNormalizedData());

                        return true;
                    }),
                    SerializationEvents::AFTER_NORMALIZATION,
                ]
            )
            ->willReturnArgument(0);

        $this->serializer->serialize($resource, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithAfterNormalization(): void
    {
        $afterNormalization = static function (array $normalizedData) {
            $normalizedData['fooBar'] = 'barFoo';

            return $normalizedData;
        };

        $serialized = $this->serializer->serialize($this->makeExpectedResource(), 'json', [
            'after_normalization' => $afterNormalization,
        ]);

        $serializedArray = \json_decode($serialized, true);

        self::assertArrayHasKey('fooBar', $serializedArray);
        self::assertEquals('barFoo', $serializedArray['fooBar']);
    }

    /**
     * @test
     */
    public function shouldSuccessDenormalize(): void
    {
        $object = $this->serializer->deserialize(\json_encode([
            'id'      => 1,
            'name'    => 'John Smith',
            'address' => [
                'country' => 'UK',
            ],
        ]), CustomerResource::class, 'json');

        self::assertEquals(new CustomerResource(1, 'John Smith', new AddressResource('UK')), $object);
    }

    /**
     * @test
     */
    public function shouldSuccessDenormalizeWithoutEventDispatcher(): void
    {
        $object = $this->serializerWithoutEventDispatcher->deserialize(\json_encode([
            'id'      => 1,
            'name'    => 'John Smith',
            'address' => [
                'country' => 'UK',
            ],
        ]), CustomerResource::class, 'json');

        self::assertEquals(new CustomerResource(1, 'John Smith', new AddressResource('UK')), $object);
    }

    /**
     * @test
     */
    public function shouldSuccessDenormalizeWithEventDispatching(): void
    {
        $data = [
            'id'      => 1,
            'name'    => 'John Smith',
            'address' => [
                'country' => 'UK',
                'city'    => 'London',
            ],
        ];

        $this->eventDispatcher->expects(self::exactly(4))
            ->method('dispatch')
            ->withConsecutive(
                [
                    self::callback(static function (BeforeDenormalizationEvent $event) use ($data) {
                        self::assertEquals($data, $event->getData());

                        return true;
                    }),
                    SerializationEvents::BEFORE_DENORMALIZATION,
                ],
                [
                    self::callback(static function (BeforeDenormalizationEvent $event) use ($data) {
                        self::assertEquals($data['address'], $event->getData());

                        return true;
                    }),
                    SerializationEvents::BEFORE_DENORMALIZATION,
                ],
                [
                    self::callback(static function (AfterDenormalizationEvent $event) use ($data) {
                        self::assertEquals($data['address'], $event->getData());
                        self::assertEquals(new AddressResource('UK', 'London'), $event->getResource());

                        return true;
                    }),
                    SerializationEvents::AFTER_DENORMALIZATION,
                ],
                [
                    self::callback(static function (AfterDenormalizationEvent $event) use ($data) {
                        self::assertEquals($data, $event->getData());
                        self::assertEquals(new CustomerResource(1, 'John Smith', new AddressResource('UK', 'London')), $event->getResource());

                        return true;
                    }),
                    SerializationEvents::AFTER_DENORMALIZATION,
                ]
            );

        $this->serializer->deserialize(\json_encode($data), CustomerResource::class, 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessDenormalizationWithBeforeDenormalization(): void
    {
        $beforeDenormalization = static function (array $data) {
            $data['address']['city'] = 'Odessa';

            return $data;
        };

        $context = [
            'before_denormalization' => $beforeDenormalization,
        ];

        $object = $this->serializer->deserialize(\json_encode([
            'id'      => 1,
            'name'    => 'Smith',
            'address' => [
                'country' => 'UA',
            ],
        ]), CustomerResource::class, 'json', $context);

        self::assertEquals(new CustomerResource(1, 'Smith', new AddressResource('UA', 'Odessa')), $object);
    }

    /**
     * Make expected resource for test
     *
     * @return CustomerResource
     */
    private function makeExpectedResource(): CustomerResource
    {
        return new CustomerResource(1, 'John Smith', new AddressResource('UK', 'London'));
    }

    /**
     * Make expected serialized array
     *
     * @return array<string, mixed>
     */
    private function makeExpectedSerializedArray(): array
    {
        return [
            'id'        => 1,
            'name'      => 'John Smith',
            'address'   => [
                'country' => 'UK',
                'city'    => 'London',
            ],
            'relations' => [],
            'actions'   => [],
        ];
    }
}

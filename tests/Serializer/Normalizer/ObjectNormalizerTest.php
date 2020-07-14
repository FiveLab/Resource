<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Normalizer;

use FiveLab\Component\Resource\Serializer\Normalizer\ObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ObjectNormalizerTest extends TestCase
{
    /**
     * @var ObjectNormalizer
     */
    private $normalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setSerializer(new Serializer());
    }

    /**
     * @test
     */
    public function shouldSuccessCallToBeforeNormalization(): void
    {
        $called = false;

        $callable = function (CustomObjectForNormalize $object, $format, $context) use (&$called) {
            $called = true;
        };

        $context = [
            'before_normalization' => $callable,
        ];

        $data = $this->normalizer->normalize(new CustomObjectForNormalize(), 'json', $context);

        self::assertEquals(['fieldFoo' => 'value1', 'fieldBar' => ['value2']], $data);
        self::assertTrue($called, 'The callback is not executed.');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfBeforeNormalizationCallbackIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid callable for before normalization. "string" given.');

        $context = ['before_normalization' => 'some'];

        $this->normalizer->normalize(new CustomObjectForNormalize(), 'xml', $context);
    }

    /**
     * @test
     */
    public function shouldSuccessCallToAfterNormalization(): void
    {
        $called = false;

        $callable = static function (array $data, CustomObjectForNormalize $object, $format, $context) use (&$called) {
            $called = true;
            self::assertEquals(['fieldFoo' => 'value1', 'fieldBar' => ['value2']], $data);

            return $data;
        };

        $context = [
            'after_normalization' => $callable,
        ];

        $data = $this->normalizer->normalize(new CustomObjectForNormalize(), 'json', $context);

        self::assertEquals(['fieldFoo' => 'value1', 'fieldBar' => ['value2']], $data);
        self::assertTrue($called, 'The callback is not executed.');
    }

    /**
     * @test
     */
    public function shouldFailIfAfterNormalizationReturnNull(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The after normalization callback should return array, but "NULL" given.');

        $callable = static function () {
        };

        $context = ['after_normalization' => $callable];

        $this->normalizer->normalize(new CustomObjectForNormalize(), 'xml', $context);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfAfterNormalizationCallbackIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid callable for after normalization. "string" given.');

        $context = ['after_normalization' => 'some'];

        $this->normalizer->normalize(new CustomObjectForNormalize(), 'json', $context);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializerWithNull(): void
    {
        $normalizer = new ObjectNormalizer(null, null, null, null, true);
        $normalizer->setSerializer(new Serializer());

        $object = new CustomObjectForNormalize();
        $object->fieldBar = '';
        $object->fieldFoo = null;

        $data = $normalizer->normalize($object, 'some', []);

        self::assertEquals(['fieldFoo' => null, 'fieldBar' => ''], $data);
    }

    /**
     * @test
     */
    public function shouldSuccessSerializeWithoutNull(): void
    {
        $normalizer = new ObjectNormalizer(null, null, null, null, false);
        $normalizer->setSerializer(new Serializer());

        $object = new CustomObjectForNormalize();
        $object->fieldBar = '';
        $object->fieldFoo = null;

        $data = $normalizer->normalize($object, 'some', []);

        self::assertEquals([], $data);
    }
}

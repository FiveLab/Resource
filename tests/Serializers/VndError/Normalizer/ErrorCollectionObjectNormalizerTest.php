<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\VndError\Normalizer;

use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorCollectionObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollectionObjectNormalizerTest extends TestCase
{
    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $normalizer;

    /**
     * @var ErrorCollectionObjectNormalizer
     */
    private $collectionNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = $this->createMock(NormalizerInterface::class);
        $this->collectionNormalizer = new ErrorCollectionObjectNormalizer();
        $this->collectionNormalizer->setNormalizer($this->normalizer);
    }

    /**
     * @test
     */
    public function shouldSuccessSupport(): void
    {
        $collection = $this->createMock(ErrorCollection::class);
        $supports = $this->collectionNormalizer->supportsNormalization($collection);

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldNotSupport(): void
    {
        $supports = $this->collectionNormalizer->supportsNormalization(new \stdClass());

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeWithNested(): void
    {
        $relation = $this->createMock(RelationInterface::class);
        $inner = new ErrorResource('inner-message', 'inner-reason', 'inner-path', ['attr'], 'identifier');
        $error = new ErrorCollection('message', 'reason', 'path', ['attr'], 'identifier');
        $error->addErrors($inner);
        $error->addRelation($relation);

        $primaryError = new ErrorResource('message', 'reason', 'path', ['attr'], 'identifier');

        $this->normalizer->expects(self::exactly(3))
            ->method('normalize')
            ->with(self::logicalOr($inner, $primaryError, new RelationCollection($relation)), 'json', ['context'])
            ->willReturnCallback(function ($error) {
                if ($error instanceof RelationCollection) {
                    return ['normalized-relation'];
                }

                return [
                    'message' => $error->getMessage(),
                ];
            });

        $normalized = $this->collectionNormalizer->normalize($error, 'json', ['context']);

        self::assertEquals([
            'message'   => 'message',
            '_links'    => ['normalized-relation'],
            '_embedded' => [
                'errors' => [
                    ['message' => 'inner-message'],
                ],
            ],
        ], $normalized);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeWithoutNested(): void
    {
        $inner = new ErrorResource('inner-message', 'inner-reason', 'inner-path', ['attr'], 'identifier');
        $error = new ErrorCollection('');
        $error->addErrors($inner);

        $this->normalizer->expects(self::exactly(1))
            ->method('normalize')
            ->with($inner, 'json', ['context'])
            ->willReturnCallback(function ($error) {
                return [
                    'message' => $error->getMessage(),
                ];
            });

        $normalized = $this->collectionNormalizer->normalize($error, 'json', ['context']);

        self::assertEquals([
            'total'     => 1,
            '_embedded' => [
                'errors' => [
                    ['message' => 'inner-message'],
                ],
            ],
        ], $normalized);
    }
}

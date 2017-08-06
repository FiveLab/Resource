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

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;
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
        $action = $this->createMock(ActionInterface::class);
        $inner = new ErrorResource('inner-message', 'inner-reason', 'inner-path', ['attr'], 'identifier');
        $error = new ErrorCollection('message', 'reason', 'path', ['attr'], 'identifier');
        $error->addErrors($inner);
        $error->addRelation($relation);
        $error->addAction($action);

        $primaryError = new ErrorResource('message', 'reason', 'path', ['attr'], 'identifier');

        $this->normalizer->expects(self::exactly(4))
            ->method('normalize')
            ->with(self::logicalOr($inner, $primaryError, new RelationCollection($relation), new ActionCollection($action)), 'json', ['context'])
            ->willReturnCallback(function ($error) {
                if ($error instanceof RelationCollection) {
                    return ['normalized-relation'];
                }

                if ($error instanceof ActionCollection) {
                    return ['normalized-actions'];
                }

                return [
                    'message' => $error->getMessage(),
                ];
            });

        $normalized = $this->collectionNormalizer->normalize($error, 'json', ['context']);

        self::assertEquals([
            'message'   => 'message',
            '_links'    => ['normalized-relation', 'normalized-actions'],
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
        $relation = $this->createMock(RelationInterface::class);
        $inner = new ErrorResource('inner-message', 'inner-reason', 'inner-path', ['attr'], 'identifier');
        $error = new ErrorCollection('');
        $error->addErrors($inner);
        $error->addRelation($relation);

        $this->normalizer->expects(self::exactly(2))
            ->method('normalize')
            ->with(self::logicalOr($inner, new RelationCollection($relation)), 'json', ['context'])
            ->willReturnCallback(function ($error) {
                if ($error instanceof RelationCollection) {
                    return ['normalized-relations'];
                }

                return [
                    'message' => $error->getMessage(),
                ];
            });

        $normalized = $this->collectionNormalizer->normalize($error, 'json', ['context']);

        self::assertEquals([
            'total'     => 1,
            '_links' => [
                'normalized-relations',
            ],
            '_embedded' => [
                'errors' => [
                    ['message' => 'inner-message'],
                ],
            ],
        ], $normalized);
    }
}

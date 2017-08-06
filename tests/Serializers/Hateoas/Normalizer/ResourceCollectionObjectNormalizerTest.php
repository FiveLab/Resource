<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializers\Hateoas\Normalizer;

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use FiveLab\Component\Resource\Resource\ResourceCollection;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\ResourceCollectionObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceCollectionObjectNormalizerTest extends TestCase
{
    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $normalizer;

    /**
     * @var ResourceCollectionObjectNormalizer
     */
    private $collectionNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = $this->createMock(NormalizerInterface::class);
        $this->collectionNormalizer = new ResourceCollectionObjectNormalizer();
        $this->collectionNormalizer->setNormalizer($this->normalizer);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeWithoutLinks(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        $collection = new ResourceCollection($resource);

        $this->normalizer->expects(self::once())
            ->method('normalize')
            ->with($resource, 'json', ['context'])
            ->willReturn(['normalized-resource']);

        $result = $this->collectionNormalizer->normalize($collection, 'json', ['context']);

        self::assertEquals([
            ['normalized-resource'],
        ], $result);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeWithLinks(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        $action = $this->createMock(ActionInterface::class);
        $relation = $this->createMock(RelationInterface::class);

        $collection = new ResourceCollection($resource);
        $collection->addAction($action);
        $collection->addRelation($relation);

        $this->normalizer->expects(self::exactly(3))
            ->method('normalize')
            ->with(self::logicalOr(new RelationCollection($relation), new ActionCollection($action), $resource), 'json', ['context'])
            ->willReturnCallback(function ($data) {
                if ($data instanceof RelationCollection) {
                    return ['normalized-relations'];
                }

                if ($data instanceof ActionCollection) {
                    return ['normalized-actions'];
                }

                return 'normalized-resource';
            });

        $result = $this->collectionNormalizer->normalize($collection, 'json', ['context']);

        self::assertEquals([
            '_links'    => [
                'normalized-relations',
                'normalized-actions',
            ],
            '_embedded' => [
                'items' => ['normalized-resource'],
            ],
        ], $result);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The normalizer support only "FiveLab\Component\Resource\Resource\ResourceCollection" but "stdClass" given.
     */
    public function shouldFailNormalizeIfSendInvalidObject(): void
    {
        $this->collectionNormalizer->normalize(new \stdClass(), 'json');
    }

    /**
     * @test
     */
    public function shouldSuccessSupports(): void
    {
        $collection = new ResourceCollection();
        $supports = $this->collectionNormalizer->supportsNormalization($collection);

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldFailSupports(): void
    {
        $supports = $this->collectionNormalizer->supportsNormalization(new \stdClass());

        self::assertFalse($supports);
    }
}

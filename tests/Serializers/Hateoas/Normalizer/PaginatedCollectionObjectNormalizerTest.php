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

use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\PaginatedCollectionObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedCollectionObjectNormalizerTest extends TestCase
{
    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $normalizer;

    /**
     * @var PaginatedCollectionObjectNormalizer
     */
    private $paginatedNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = $this->createMock(NormalizerInterface::class);
        $this->paginatedNormalizer = new PaginatedCollectionObjectNormalizer();
        $this->paginatedNormalizer->setNormalizer($this->normalizer);
    }

    /**
     * @test
     */
    public function shouldSuccessSupports(): void
    {
        $collection = $this->createMock(PaginatedResourceCollection::class);
        $supports = $this->paginatedNormalizer->supportsNormalization($collection);

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldFailSupports(): void
    {
        $supports = $this->paginatedNormalizer->supportsNormalization(new \stdClass());

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        $paginated = new PaginatedResourceCollection(2, 10, 22, $resource);
        $relation = $this->createMock(RelationInterface::class);
        $paginated->addRelation($relation);

        $this->normalizer->expects(self::exactly(2))
            ->method('normalize')
            ->with(self::logicalOr($resource, new RelationCollection($relation)), 'json', ['context'])
            ->willReturnCallback(function ($object) {
                switch (true) {
                    case $object instanceof RelationCollection:
                        return ['normalized-relations'];

                    case $object instanceof ResourceInterface:
                        return ['normalized-resource'];

                    default:
                        self::fail('Invalid object.');
                }
            });

        $normalized = $this->paginatedNormalizer->normalize($paginated, 'json', ['context']);

        self::assertEquals([
            'state'     => [
                'page'   => 2,
                'limit'  => 10,
                'pages'  => 3,
                'total'  => 22,
                '_links' => [
                    'normalized-relations',
                ],
            ],
            '_embedded' => [
                'items' => [
                    ['normalized-resource'],
                ],
            ],
        ], $normalized);
    }
}

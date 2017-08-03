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

use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Normalizer\PaginatedCollectionNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedCollectionNormalizerTest extends TestCase
{
    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $normalizer;

    /**
     * @var PaginatedCollectionNormalizer
     */
    private $paginatedNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = $this->createMock(NormalizerInterface::class);
        $this->paginatedNormalizer = new PaginatedCollectionNormalizer();
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
    public function shouldNotSupports(): void
    {
        $supports = $this->paginatedNormalizer->supportsNormalization(new \stdCLass());

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        $paginatedCollection = new PaginatedResourceCollection(2, 10, 22, $resource);

        $this->normalizer->expects(self::once())
            ->method('normalize')
            ->with($resource, 'json', ['context'])
            ->willReturn(['normalized resource']);

        $normalized = $this->paginatedNormalizer->normalize($paginatedCollection, 'json', ['context']);

        self::assertEquals([
            'page'  => 2,
            'total' => 22,
            'limit' => 10,
            'items' => [['normalized resource']],
        ], $normalized);
    }
}

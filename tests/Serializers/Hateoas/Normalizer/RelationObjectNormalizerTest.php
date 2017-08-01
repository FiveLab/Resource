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

use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationObjectNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationObjectNormalizerTest extends TestCase
{
    /**
     * @var RelationObjectNormalizer
     */
    private $normalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = new RelationObjectNormalizer();
    }

    /**
     * @test
     */
    public function shouldSuccessSupports(): void
    {
        $relation = $this->createMock(RelationInterface::class);
        $supports = $this->normalizer->supportsNormalization($relation, 'json');

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldNotSupports(): void
    {
        $supports = $this->normalizer->supportsNormalization(new \stdClass());

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        $relation = new Relation('self', new Href('/self', true), ['field1' => 'value1']);

        $normalized = $this->normalizer->normalize($relation, 'json');

        self::assertEquals([
            'href' => '/self',
            'templated' => true,
            'attributes' => [
                'field1' => 'value1'
            ]
        ], $normalized);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The normalizer support only "FiveLab\Component\Resource\Resource\Relation\RelationInterface" but "stdClass" given.
     */
    public function shouldFailNormalizeIfSendInvalidObject(): void
    {
        $this->normalizer->normalize(new \stdClass(), 'json');
    }
}
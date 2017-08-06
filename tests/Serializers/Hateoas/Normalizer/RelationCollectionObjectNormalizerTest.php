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

use FiveLab\Component\Resource\Resource\Action\Action;
use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\Method;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationCollectionObjectNormalizerTest extends TestCase
{
    /**
     * @var RelationCollectionObjectNormalizer
     */
    private $normalizer;

    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $innerNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->innerNormalizer = $this->createMock(NormalizerInterface::class);
        $this->normalizer = new RelationCollectionObjectNormalizer();
        $this->normalizer->setNormalizer($this->innerNormalizer);
    }

    /**
     * @test
     */
    public function shouldSuccessSupportRelationCollection(): void
    {
        $supports = $this->normalizer->supportsNormalization(new RelationCollection());
        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessSupportActionCollection(): void
    {
        $supports = $this->normalizer->supportsNormalization(new ActionCollection());

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldNotSupport(): void
    {
        $supports = $this->normalizer->supportsNormalization(new \stdClass());
        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeRelationCollection(): void
    {
        $relation = new Relation('self', new Href('/self'), ['attr' => 'value']);
        $collection = new RelationCollection($relation);

        $this->innerNormalizer->expects(self::once())
            ->method('normalize')
            ->with($relation)
            ->willReturn(['href' => '/self', 'attributes' => ['attr' => 'value']]);

        $normalized = $this->normalizer->normalize($collection);

        self::assertEquals([
            'self' => [
                'href' => '/self',
                'attributes' => [
                    'attr' => 'value',
                ],
            ],
        ], $normalized);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalizeActionCollection(): void
    {
        $action = new Action('self', new Href('/self'), Method::post(), ['attr' => 'value']);
        $collection = new ActionCollection($action);

        $this->innerNormalizer->expects(self::once())
            ->method('normalize')
            ->with($action)
            ->willReturn(['href' => '/self', 'attributes' => ['attr' => 'value']]);

        $normalized = $this->normalizer->normalize($collection);

        self::assertEquals([
            'self' => [
                'href' => '/self',
                'attributes' => [
                    'attr' => 'value',
                ],
            ],
        ], $normalized);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The normalizer support only "FiveLab\Component\Resource\Resource\Relation\RelationCollection" or "FiveLab\Component\Resource\Resource\Action\ActionCollection" but "stdClass" given.
     */
    public function shouldFailNormalizeIfSendInvalidObject(): void
    {
        $this->normalizer->normalize(new \stdClass(), 'json');
    }
}

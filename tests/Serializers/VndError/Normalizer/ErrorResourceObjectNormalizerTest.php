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
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use FiveLab\Component\Resource\Resource\Error\ErrorResourceInterface;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorResourceObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorResourceObjectNormalizerTest extends TestCase
{
    /**
     * @var NormalizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $normalizer;

    /**
     * @var ErrorResourceObjectNormalizer
     */
    private $errorNormalizer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->normalizer = $this->createMock(NormalizerInterface::class);
        $this->errorNormalizer = new ErrorResourceObjectNormalizer();
        $this->errorNormalizer->setNormalizer($this->normalizer);
    }

    /**
     * @test
     */
    public function shouldSuccessSupports(): void
    {
        $error = $this->createMock(ErrorResourceInterface::class);
        $supports = $this->errorNormalizer->supportsNormalization($error);

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldNotSupports(): void
    {
        $supports = $this->errorNormalizer->supportsNormalization(new \stdClass());

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        $relation = $this->createMock(RelationInterface::class);
        $action = $this->createMock(ActionInterface::class);
        $error = new ErrorResource('message', 'reason', 'path', ['attr'], 'identifier');
        $error->addRelation($relation);
        $error->addAction($action);

        $this->normalizer->expects(self::exactly(2))
            ->method('normalize')
            ->with(self::logicalOr(new RelationCollection($relation), new ActionCollection($action)), 'json', ['context'])
            ->willReturnCallback(function ($data) {
                if ($data instanceof RelationCollection) {
                    return ['normalized-relations'];
                }

                if ($data instanceof ActionCollection) {
                    return ['normalized-actions'];
                }

                self::fail('Invalid type of data');

                return null;
            });

        $normalized = $this->errorNormalizer->normalize($error, 'json', ['context']);

        self::assertEquals([
            'message' => 'message',
            'path'    => 'path',
            'logref'  => 'identifier',
            '_links'  => ['normalized-relations', 'normalized-actions'],
        ], $normalized);
    }
}

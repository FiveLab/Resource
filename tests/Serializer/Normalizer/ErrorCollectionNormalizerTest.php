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

use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use FiveLab\Component\Resource\Resource\Error\ErrorResourceInterface;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Serializer\Normalizer\ErrorCollectionObjectNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollectionNormalizerTest extends TestCase
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
    public function shouldSuccessSupportNormalization(): void
    {
        $data = $this->createMock(ErrorCollection::class);
        $supports = $this->collectionNormalizer->supportsNormalization($data, 'json');

        self::assertTrue($supports);
    }

    /**
     * @test
     */
    public function shouldFailSupportNormalizationIfSendInvalidObject(): void
    {
        $supports = $this->collectionNormalizer->supportsNormalization(new \stdClass(), 'json');

        self::assertFalse($supports);
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        $innerError = new ErrorResource(
            'inner message',
            'inner reason',
            '/inner-path',
            ['inner-attr'],
            'inner-identifier'
        );

        $collection = new ErrorCollection('message', 'reason', 'path', ['attr'], 'identifier');
        $collection->addErrors($innerError);
        $collection->addRelation(new Relation('self', new Href('/some')));

        $this->normalizer->expects(self::exactly(2))
            ->method('normalize')
            ->with(self::logicalNot(self::isNull()), 'json', ['context'])
            ->willReturnCallback(function (ErrorResourceInterface $error) {
                return ['message' => $error->getMessage()];
            });

        $normalized = $this->collectionNormalizer->normalize($collection, 'json', ['context']);

        self::assertEquals([
            'message' => 'message',
            'errors'  => [
                [
                    'message' => 'inner message',
                ],
            ],
        ], $normalized);
    }
}

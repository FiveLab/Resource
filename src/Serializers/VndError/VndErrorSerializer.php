<?php

declare(strict_types = 1);

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializers\VndError;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionObjectNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationObjectNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorCollectionObjectNormalizer;
use FiveLab\Component\Resource\Serializers\VndError\Normalizer\ErrorResourceObjectNormalizer;

/**
 * The serializer for serialize errors to Vnd.Error format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class VndErrorSerializer implements ResourceSerializerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $format;

    /**
     * Constructor.
     *
     * @param SerializerInterface $serializer
     * @param string              $format
     */
    public function __construct(SerializerInterface $serializer, string $format)
    {
        $this->serializer = $serializer;
        $this->format = $format;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(ResourceInterface $resource, ResourceSerializationContext $context): string
    {
        $innerContext = [
            'normalizers' => [
                new ErrorResourceObjectNormalizer(),
                new ErrorCollectionObjectNormalizer(),
                new RelationObjectNormalizer(),
                new RelationCollectionObjectNormalizer(),
            ],
        ];

        return $this->serializer->serialize($resource, $this->format, $innerContext);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize(
        string $data,
        string $resourceClass,
        ResourceSerializationContext $context
    ): ResourceInterface {
        throw new DeserializationNotSupportException('The Vnd.Error not support deserialization.');
    }
}

<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializers\Hateoas;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;
use FiveLab\Component\Resource\Serializer\SerializerInterface;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationCollectionObjectNormalizer;
use FiveLab\Component\Resource\Serializers\Hateoas\Normalizer\RelationObjectNormalizer;

/**
 * Hateoas serializer.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class HateoasSerializer implements ResourceSerializerInterface
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
            'after_normalization' => function (array $data) {
                return $this->fixRelations($data);
            },
            'normalizers' => [
                new RelationCollectionObjectNormalizer(),
                new RelationObjectNormalizer(),
            ],
        ];

        return $this->serializer->serialize($resource, $this->format, $innerContext);
    }

    /**
     * {@inheritdoc}
     *
     * @throws DeserializationNotSupportException
     */
    public function deserialize(
        string $data,
        string $resourceClass,
        ResourceSerializationContext $context
    ): ResourceInterface {
        throw new DeserializationNotSupportException('The hateoas not support deserialization.');
    }

    /**
     * Fix relations after normalization
     *
     * @param array $data
     *
     * @return array
     */
    public function fixRelations(array $data): array
    {
        if (array_key_exists('relations', $data)) {
            $data['_links'] = $data['relations'];
            unset($data['relations']);
        }

        return $data;
    }
}

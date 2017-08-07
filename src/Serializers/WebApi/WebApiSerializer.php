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

namespace FiveLab\Component\Resource\Serializers\WebApi;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;
use FiveLab\Component\Resource\Serializer\SerializerInterface;

/**
 * Default Web API serializer.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class WebApiSerializer implements ResourceSerializerInterface
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
                return $this->removeRelations($data);
            },
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
        return $this->serializer->deserialize($data, $resourceClass, $this->format);
    }

    /**
     * Remove resources from data
     *
     * @param array $data
     *
     * @return array
     */
    protected function removeRelations(array $data): array
    {
        unset($data['relations'], $data['actions']);

        return $data;
    }
}

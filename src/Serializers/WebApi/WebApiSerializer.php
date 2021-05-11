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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

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
    private SerializerInterface $serializer;

    /**
     * @var string
     */
    private string $format;

    /**
     * @var array<string, mixed>
     */
    private array $serializationContext;

    /**
     * Constructor.
     *
     * @param SerializerInterface  $serializer
     * @param string               $format
     * @param array<string, mixed> $serializationContext
     */
    public function __construct(SerializerInterface $serializer, string $format, array $serializationContext)
    {
        $this->serializer = $serializer;
        $this->format = $format;
        $this->serializationContext = $serializationContext;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(ResourceInterface $resource, ResourceSerializationContext $context): string
    {
        $serializationContext = \array_merge($this->serializationContext, [
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'relations',
                'actions',
            ],
        ]);

        return $this->serializer->serialize($resource, $this->format, $serializationContext);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize(string $data, string $resourceClass, ResourceSerializationContext $context): ResourceInterface
    {
        return $this->serializer->deserialize($data, $resourceClass, $this->format);
    }
}

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
use Symfony\Component\Serializer\SerializerInterface;

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
    public function __construct(SerializerInterface $serializer, string $format, array $serializationContext = [])
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
        return $this->serializer->serialize($resource, $this->format, $this->serializationContext);
    }

    /**
     * {@inheritdoc}
     *
     * @throws DeserializationNotSupportException
     */
    public function deserialize(string $data, string $resourceClass, ResourceSerializationContext $context): ResourceInterface
    {
        throw new DeserializationNotSupportException('The Vnd.Error not support deserialization.');
    }
}

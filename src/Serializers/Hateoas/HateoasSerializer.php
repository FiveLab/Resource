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

namespace FiveLab\Component\Resource\Serializers\Hateoas;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use FiveLab\Component\Resource\Serializer\Exception\DeserializationNotSupportException;
use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;
use FiveLab\Component\Resource\Serializer\Serializer;

/**
 * Hateoas serializer.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class HateoasSerializer implements ResourceSerializerInterface
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

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
     * @param Serializer           $serializer
     * @param string               $format
     * @param array<string, mixed> $serializationContext
     */
    public function __construct(Serializer $serializer, string $format, array $serializationContext = [])
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
            'after_normalization' => function (array $data) {
                return $this->fixRelations($data);
            },
        ]);

        return $this->serializer->serialize($resource, $this->format, $serializationContext);
    }

    /**
     * {@inheritdoc}
     *
     * @throws DeserializationNotSupportException
     */
    public function deserialize(string $data, string $resourceClass, ResourceSerializationContext $context): ResourceInterface
    {
        throw new DeserializationNotSupportException('The hateoas not support deserialization.');
    }

    /**
     * Fix relations after normalization
     *
     * @param array $data
     *
     * @return array<string, array>
     */
    protected function fixRelations(array $data): array
    {
        $links = [];

        if (\array_key_exists('relations', $data)) {
            $links = \array_merge($links, $data['relations']);
            unset($data['relations']);
        }

        if (\array_key_exists('actions', $data)) {
            $links = \array_merge($links, $data['actions']);
            unset($data['actions']);
        }

        if (\count($links)) {
            $data['_links'] = $links;
        }

        return $data;
    }
}

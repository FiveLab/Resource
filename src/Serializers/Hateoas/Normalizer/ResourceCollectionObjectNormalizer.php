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

namespace FiveLab\Component\Resource\Serializers\Hateoas\Normalizer;

use FiveLab\Component\Resource\Resource\ResourceCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * The normalizer for normalize resource collection.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceCollectionObjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param ResourceCollection $object
     *
     * @throws \InvalidArgumentException
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof ResourceCollection) {
            throw new \InvalidArgumentException(sprintf(
                'The normalizer support only "%s" but "%s" given.',
                ResourceCollection::class,
                is_object($object) ? get_class($object) : gettype($object)
            ));
        }

        $data = [];
        $links = [];

        if (count($object->getRelations())) {
            $links = array_merge($links, $this->normalizer->normalize($object->getRelations(), $format, $context));
        }

        if (count($object->getActions())) {
            $links = array_merge($links, $this->normalizer->normalize($object->getActions(), $format, $context));
        }

        foreach ($object as $resource) {
            $data[] = $this->normalizer->normalize($resource, $format, $context);
        }

        if (count($links)) {
            return [
                '_links' => $links,
                '_embedded' => [
                    'items' => $data,
                ],
            ];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof ResourceCollection;
    }
}

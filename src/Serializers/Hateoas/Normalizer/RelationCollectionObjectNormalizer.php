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

use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize relation collection for HATEOAS.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationCollectionObjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param RelationCollection $object
     *
     * @throws \InvalidArgumentException
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        if (!$object instanceof RelationCollection) {
            throw new \InvalidArgumentException(sprintf(
                'The normalizer support only "%s" but "%s" given.',
                RelationCollection::class,
                is_object($object) ? get_class($object) : gettype($object)
            ));
        }

        $data = [];

        foreach ($object as $relation) {
            $data[$relation->getName()] = $this->normalizer->normalize($relation, $format);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof RelationCollection;
    }
}

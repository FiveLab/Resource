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

use FiveLab\Component\Resource\Resource\Action\ActionInterface;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize relation object for HATEOAS.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationObjectNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        if (!$object instanceof RelationInterface && !$object instanceof ActionInterface) {
            throw new \InvalidArgumentException(\sprintf(
                'The normalizer support only "%s" or "%s" but "%s" given.',
                RelationInterface::class,
                ActionInterface::class,
                \is_object($object) ? \get_class($object) : \gettype($object)
            ));
        }

        $data = [
            'href' => $object->getHref()->getPath(),
        ];

        if ($object->getHref()->isTemplated()) {
            $data['templated'] = true;
        }

        if (count($object->getAttributes())) {
            $data['attributes'] = $object->getAttributes();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && ($data instanceof RelationInterface || $data instanceof ActionInterface);
    }
}

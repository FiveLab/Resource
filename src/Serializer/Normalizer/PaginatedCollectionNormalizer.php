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

namespace FiveLab\Component\Resource\Serializer\Normalizer;

use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize paginated collection.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedCollectionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof PaginatedResourceCollection;
    }

    /**
     * {@inheritdoc}
     *
     * @param PaginatedResourceCollection $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $normalized = [
            'page' => $object->getPage(),
            'limit' => $object->getLimit(),
            'total' => $object->getTotal(),
            'items' => [],
        ];

        foreach ($object as $item) {
            $normalized['items'][] = $this->normalizer->normalize($item, $format, $context);
        }

        return $normalized;
    }
}

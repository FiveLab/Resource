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

use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * The normalizer for normalize paginated resource collection for HATEOAS format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedCollectionObjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
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
        $normalizedItems = [];

        foreach ($object as $item) {
            $normalizedItems[] = $this->normalizer->normalize($item, $format, $context);
        }

        $normalizedRelations = $this->normalizer->normalize($object->getRelations(), $format, $context);

        return [
            'state'     => [
                'page'   => $object->getPage(),
                'limit'  => $object->getLimit(),
                'pages'  => (int) (ceil($object->getTotal() / $object->getLimit())),
                'total'  => $object->getTotal(),
                '_links' => $normalizedRelations,
            ],
            '_embedded' => [
                'items' => $normalizedItems,
            ],
        ];
    }
}

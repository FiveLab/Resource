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

namespace FiveLab\Component\Resource\Serializers\VndError\Normalizer;

use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize error collection for Vnd.Error format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollectionObjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof ErrorCollection;
    }

    /**
     * {@inheritdoc}
     *
     * @param ErrorCollection $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $nested = $object->getMessage() || $object->getReason();

        $errors = [];

        foreach ($object as $item) {
            $errors[] = $this->normalizer->normalize($item, $format, $context);
        }

        $links = [];

        if (count($object->getRelations())) {
            $links = array_merge($links, $this->normalizer->normalize($object->getRelations(), $format, $context));
        }

        if (count($object->getActions())) {
            $links = array_merge($links, $this->normalizer->normalize($object->getActions(), $format, $context));
        }

        if ($nested) {
            $innerError = new ErrorResource(
                $object->getMessage(),
                $object->getReason(),
                $object->getPath(),
                $object->getAttributes(),
                $object->getIdentifier()
            );

            $data = $this->normalizer->normalize($innerError, $format, $context);

            if (count($links)) {
                $data['_links'] = $links;
            }

            $data['_embedded'] = [
                'errors' => $errors,
            ];

            return $data;
        }

        $data = [
            'total' => count($errors),
            '_embedded' => [
                'errors' => $errors,
            ],
        ];

        if (count($links)) {
            $data['_links'] = $links;
        }

        return $data;
    }
}

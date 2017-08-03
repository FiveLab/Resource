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

use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize error collection.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollectionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ErrorCollection;
    }

    /**
     * {@inheritdoc}
     *
     * @param ErrorCollection $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $normalized = ['errors' => []];

        foreach ($object as $innerError) {
            $normalized['errors'][] = $this->normalizer->normalize($innerError, $format, $context);
        }

        $normalized = $this->appendCollectionAttributes($normalized, $object, (string) $format, $context);

        return $normalized;
    }

    /**
     * Append collection attributes to
     *
     * @param array           $data
     * @param ErrorCollection $error
     * @param string          $format
     * @param array           $context
     *
     * @return array
     */
    public function appendCollectionAttributes(
        array $data,
        ErrorCollection $error,
        string $format,
        array $context
    ): array {
        $innerError = new ErrorResource(
            $error->getMessage(),
            $error->getReason(),
            $error->getPath(),
            $error->getAttributes(),
            $error->getIdentifier()
        );

        foreach ($error->getRelations() as $relation) {
            $innerError->addRelation($relation);
        }

        $normalizedInnerError = $this->normalizer->normalize($innerError, $format, $context);

        return array_merge($normalizedInnerError, $data);
    }
}

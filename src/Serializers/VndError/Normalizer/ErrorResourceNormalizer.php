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

use FiveLab\Component\Resource\Resource\Error\ErrorResourceInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for normalize error resource for Vnd.Error format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorResourceNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && $data instanceof ErrorResourceInterface;
    }

    /**
     * {@inheritdoc}
     *
     * @param ErrorResourceInterface $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $links = [];

        if (\count($object->getRelations())) {
            // @phpstan-ignore-next-line
            $links = \array_merge($links, $this->normalizer->normalize($object->getRelations(), $format, $context));
        }

        if (\count($object->getActions())) {
            // @phpstan-ignore-next-line
            $links = \array_merge($links, $this->normalizer->normalize($object->getActions(), $format, $context));
        }

        $data = [
            'message' => $object->getMessage(),
        ];

        if ($object->getPath()) {
            $data['path'] = $object->getPath();
        }

        if ($object->getIdentifier()) {
            $data['logref'] = $object->getIdentifier();
        }

        if (\count($links)) {
            $data['_links'] = $links;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            ErrorResourceInterface::class => true,
        ];
    }
}

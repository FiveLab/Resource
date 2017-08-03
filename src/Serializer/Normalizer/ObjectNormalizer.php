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

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer as SymfonyObjectNormalizer;

/**
 * Extend default object normalizer for add ability for run custom code before and after normalization
 * and all ability for remove nullable attributes from structure.
 *
 * We should extend default symfony serializer for add ability for adding custom normalizers.
 */
class ObjectNormalizer extends SymfonyObjectNormalizer
{
    /**
     * @var bool
     */
    private $serializeNull;

    /**
     * Constructor.
     *
     * @param ClassMetadataFactoryInterface  $classMetadataFactory
     * @param NameConverterInterface         $nameConverter
     * @param PropertyAccessorInterface      $propertyAccessor
     * @param PropertyTypeExtractorInterface $propertyTypeExtractor
     * @param bool                           $serializeNull
     */
    public function __construct(
        ClassMetadataFactoryInterface $classMetadataFactory = null,
        NameConverterInterface $nameConverter = null,
        PropertyAccessorInterface $propertyAccessor = null,
        PropertyTypeExtractorInterface $propertyTypeExtractor = null,
        bool $serializeNull = true
    ) {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);

        $this->serializeNull = $serializeNull;
    }


    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        // Call to before normalization callback
        if (array_key_exists('before_normalization', $context)) {
            $beforeNormalization = $context['before_normalization'];

            if (!is_callable($beforeNormalization)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid callable for before normalization. "%s" given.',
                    is_object($beforeNormalization) ? get_class($beforeNormalization) : gettype($beforeNormalization)
                ));
            }

            $beforeNormalization($object, $format, $context);
        }

        // Normalize object
        $data = parent::normalize($object, $format, $context);

        if (!$this->serializeNull) {
            $data = $this->removeNullableAttributes($data);
        }

        // Call to after normalization callback
        if (array_key_exists('after_normalization', $context)) {
            $afterNormalization = $context['after_normalization'];

            if (!is_callable($afterNormalization)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid callable for after normalization. "%s" given.',
                    is_object($afterNormalization) ? get_class($afterNormalization) : gettype($afterNormalization)
                ));
            }

            $data = $afterNormalization($data, $object, $format, $context);

            if (!$data || !is_array($data)) {
                throw new \LogicException(sprintf(
                    'The after normalization callback should return array, but "%s" given.',
                    is_object($data) ? get_class($data) : gettype($data)
                ));
            }
        }

        return $data;
    }

    /**
     * Remove nullable attributes
     *
     * @param array $data
     *
     * @return array
     */
    private function removeNullableAttributes(array $data): array
    {
        return array_filter($data, function ($value) {
            return (bool) $value;
        });
    }
}

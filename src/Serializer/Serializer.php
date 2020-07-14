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

namespace FiveLab\Component\Resource\Serializer;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\BeforeDenormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\BeforeNormalizationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * Override the default serializer for add ability for adding dynamically
 * normalizers before serialization and deserialization processes.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Serializer extends SymfonySerializer implements SerializerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Constructor.
     *
     * @param array                    $normalizers
     * @param array                    $encoders
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(array $normalizers, array $encoders, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($normalizers, $encoders);

        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function normalize($data, $format = null, array $context = [])
    {
        if ($data instanceof ResourceInterface) {
            $event = new BeforeNormalizationEvent($data, (string) $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::BEFORE_NORMALIZATION, $event);
        }

        $countNormalizers = 0;

        if (\array_key_exists('normalizers', $context)) {
            /** @var NormalizerInterface[] $normalizers */
            $normalizers = \array_reverse($context['normalizers']);

            foreach ($normalizers as $normalizer) {
                if ($normalizer instanceof NormalizerInterface) {
                    $countNormalizers++;

                    $this->prepareNormalizer($normalizer);
                    \array_unshift($this->normalizers, $normalizer);
                }
            }
        }

        try {
            $normalized = parent::normalize($data, $format, $context);
        } finally {
            for ($i = 0; $i < $countNormalizers; $i++) {
                \array_shift($this->normalizers);
            }
        }

        if ($data instanceof ResourceInterface) {
            $event = new AfterNormalizationEvent($data, $normalized, (string) $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::AFTER_NORMALIZATION, $event);
        }

        return $normalized;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        if (\is_a($type, ResourceInterface::class, true)) {
            $event = new BeforeDenormalizationEvent($data, $type, $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::BEFORE_DENORMALIZATION, $event);
        }

        $countDenormalizers = 0;

        if (\array_key_exists('normalizers', $context)) {
            /** @var NormalizerInterface[] $normalizers */
            $normalizers = \array_reverse($context['normalizers']);

            foreach ($normalizers as $normalizer) {
                if ($normalizer instanceof DenormalizerInterface) {
                    $countDenormalizers++;

                    $this->prepareDenormalizer($normalizer);
                    \array_unshift($this->normalizers, $normalizer);
                }
            }
        }

        try {
            $denormalized = parent::denormalize($data, $type, $format, $context);
        } finally {
            for ($i = 0; $i < $countDenormalizers; $i++) {
                \array_shift($this->normalizers);
            }
        }

        if (\is_a($type, ResourceInterface::class, true)) {
            $event = new AfterDenormalizationEvent($data, $denormalized, (string) $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::AFTER_DENORMALIZATION, $event);
        }

        return $denormalized;
    }

    /**
     * Prepare normalizer
     *
     * @param NormalizerInterface $normalizer
     */
    private function prepareNormalizer(NormalizerInterface $normalizer): void
    {
        if ($normalizer instanceof NormalizerAwareInterface) {
            $normalizer->setNormalizer($this);
        }
    }

    /**
     * Prepare denormalizer
     *
     * @param DenormalizerInterface $denormalizer
     */
    private function prepareDenormalizer(DenormalizerInterface $denormalizer): void
    {
        if ($denormalizer instanceof DenormalizerAwareInterface) {
            $denormalizer->setDenormalizer($this);
        }
    }
}

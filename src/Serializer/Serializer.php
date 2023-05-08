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
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * Override the default serializer for add ability for adding eventable and hook system.
 * Note: we use setter for injection for not affect original constructor.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Serializer extends SymfonySerializer
{
    /**
     * @var EventDispatcherInterface|null
     */
    private ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * Set event dispatcher
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Throwable
     */
    public function normalize(mixed $data, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        if ($data instanceof ResourceInterface && $this->eventDispatcher) {
            $event = new BeforeNormalizationEvent($data, (string) $format, $context);
            $this->eventDispatcher->dispatch($event, SerializationEvents::BEFORE_NORMALIZATION);
        }

        $normalized = parent::normalize($data, $format, $context);

        if ($afterNormalization = $context['after_normalization'] ?? null) {
            $normalized = $afterNormalization($normalized, $data);
        }

        if ($data instanceof ResourceInterface && $this->eventDispatcher) {
            $event = new AfterNormalizationEvent($data, $normalized, (string) $format, $context);
            $this->eventDispatcher->dispatch($event, SerializationEvents::AFTER_NORMALIZATION);
        }

        return $normalized;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        if (\is_a($type, ResourceInterface::class, true) && $this->eventDispatcher) {
            $event = new BeforeDenormalizationEvent($data, $type, (string) $format, $context);
            $this->eventDispatcher->dispatch($event, SerializationEvents::BEFORE_DENORMALIZATION);
        }

        if ($beforeDenormalization = $context['before_denormalization'] ?? null) {
            $data = $beforeDenormalization($data);
        }

        $denormalized = parent::denormalize($data, $type, $format, $context);

        if (\is_a($type, ResourceInterface::class, true) && $this->eventDispatcher) {
            $event = new AfterDenormalizationEvent($data, $denormalized, (string) $format, $context);
            $this->eventDispatcher->dispatch($event, SerializationEvents::AFTER_DENORMALIZATION);
        }

        return $denormalized;
    }
}

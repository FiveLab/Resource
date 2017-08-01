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
use FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent;
use FiveLab\Component\Resource\Serializer\Events\BeforeNormalizationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @param EventDispatcherInterface $eventDispatcher
     * @param array                    $normalizers
     * @param array                    $encoders
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        array $normalizers = [],
        array $encoders = []
    ) {
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
            $event = new BeforeNormalizationEvent($data, $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::BEFORE_NORMALIZATION, $event);
        }

        $countNormalizers = 0;

        if (array_key_exists('normalizers', $context)) {
            $countNormalizers = count($context['normalizers']);
            /** @var NormalizerInterface[] $normalizers */
            $normalizers = $context['normalizers'];

            foreach ($normalizers as $normalizer) {
                $this->prepareNormalizer($normalizer);
                array_unshift($this->normalizers, $normalizer);
            }
        }

        try {
            $normalized = parent::normalize($data, $format, $context);
        } catch (\Exception $e) {
            for ($i = 0; $i < $countNormalizers; $i++) {
                array_shift($this->normalizers);
            }

            throw $e;
        }

        if ($data instanceof ResourceInterface) {
            $event = new AfterNormalizationEvent($data, $normalized, $format, $context);
            $this->eventDispatcher->dispatch(SerializationEvents::AFTER_NORMALIZATION, $event);
        }

        return $normalized;
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
}

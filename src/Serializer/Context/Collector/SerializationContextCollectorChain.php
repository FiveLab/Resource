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

namespace FiveLab\Component\Resource\Serializer\Context\Collector;

use FiveLab\Component\Resource\Serializer\Context\MutableSerializationContext;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;

/**
 * Chain collector for collect serialization context.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class SerializationContextCollectorChain implements SerializationContextCollectorInterface
{
    /**
     * @var \SplQueue|SerializationContextCollectorInterface[]
     */
    private $collectors;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->collectors = new \SplQueue();
    }

    /**
     * Add the collector to chain
     *
     * @param SerializationContextCollectorInterface $collector
     */
    public function add(SerializationContextCollectorInterface $collector): void
    {
        $this->collectors->enqueue($collector);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(): ResourceSerializationContext
    {
        $serializationContext = new MutableSerializationContext([]);

        foreach ($this->collectors as $collector) {
            $context = $collector->collect();
            $serializationContext = $serializationContext->merge($context);
        }

        return $serializationContext->copy();
    }
}

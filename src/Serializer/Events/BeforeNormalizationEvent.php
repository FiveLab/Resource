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

namespace FiveLab\Component\Resource\Serializer\Events;

use FiveLab\Component\Resource\Resource\ResourceInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Before normalization event.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class BeforeNormalizationEvent extends Event
{
    /**
     * @var ResourceInterface
     */
    private ResourceInterface $resource;

    /**
     * @var string
     */
    private string $format;

    /**
     * @var array
     */
    private array $context;

    /**
     * Constructor.
     *
     * @param ResourceInterface $resource
     * @param string            $format
     * @param array             $context
     */
    public function __construct(ResourceInterface $resource, string $format, array $context)
    {
        $this->resource = $resource;
        $this->format = $format;
        $this->context = $context;
    }

    /**
     * Get resource
     *
     * @return ResourceInterface
     */
    public function getResource(): ResourceInterface
    {
        return $this->resource;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Get context
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }
}

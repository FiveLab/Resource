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
use Symfony\Component\EventDispatcher\Event;

/**
 * After success normalization event.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AfterNormalizationEvent extends Event
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $format;

    /**
     * @var array
     */
    private $context;

    /**
     * Constructor.
     *
     * @param ResourceInterface $resource
     * @param array             $data
     * @param string            $format
     * @param array             $context
     */
    public function __construct(ResourceInterface $resource, array $data, string $format, array $context)
    {
        $this->resource = $resource;
        $this->data = $data;
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
     * Get the normalized data
     *
     * @return array
     */
    public function getNormalizedData(): array
    {
        return $this->data;
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

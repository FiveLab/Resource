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
 * After denormalization event.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AfterDenormalizationEvent extends Event
{
    /**
     * @var mixed
     */
    private $data;

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
     * @param mixed             $data
     * @param ResourceInterface $resource
     * @param string            $format
     * @param array             $context
     */
    public function __construct($data, ResourceInterface $resource, string $format, array $context)
    {
        $this->data = $data;
        $this->resource = $resource;
        $this->format = $format;
        $this->context = $context;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get denormalized resource
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

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

use Symfony\Component\EventDispatcher\Event;

/**
 * Before denormalization event.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class BeforeDenormalizationEvent extends Event
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $type;

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
     * @param mixed  $data
     * @param string $type
     * @param string $format
     * @param array  $context
     */
    public function __construct($data, string $type, string $format, array $context)
    {
        $this->data = $data;
        $this->type = $type;
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
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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

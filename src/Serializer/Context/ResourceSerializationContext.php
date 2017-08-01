<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializer\Context;

/**
 * Default resource serialization context.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceSerializationContext
{
    /**
     * @var array
     */
    protected $payload;

    /**
     * Constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        return $this->payload[$key] ?? $default;
    }
}

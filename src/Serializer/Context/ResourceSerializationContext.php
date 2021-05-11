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

namespace FiveLab\Component\Resource\Serializer\Context;

/**
 * Default resource serialization context.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceSerializationContext
{
    /**
     * @var array<string, mixed>
     */
    protected array $payload;

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
     * Get data from context
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->payload[$key] ?? $default;
    }
}

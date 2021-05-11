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

namespace FiveLab\Component\Resource\Assembler\Context;

/**
 * The context for assemble resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AssembleContext
{
    /**
     * @var array<string, mixed>
     */
    private array $payload;

    /**
     * Constructor.
     *
     * @param array<string, mixed> $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * Get the element from context
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function get(string $key, $value = null)
    {
        return $this->payload[$key] ?? $value;
    }
}

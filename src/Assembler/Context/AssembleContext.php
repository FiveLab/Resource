<?php

declare(strict_types=1);

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
     * @var mixed
     */
    private $payload;

    /**
     * Constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $value = null)
    {
        return $this->payload[$key] ?? $value;
    }
}

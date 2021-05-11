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

namespace FiveLab\Component\Resource\Presentation;

use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * The default presentation for send the resource to the client.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Presentation implements PresentationInterface
{
    /**
     * @var ResourceInterface|null
     */
    private ?ResourceInterface $resource;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * Constructor.
     *
     * @param int                    $statusCode
     * @param ResourceInterface|null $resource
     */
    public function __construct(int $statusCode, ResourceInterface $resource = null)
    {
        $this->resource = $resource;
        $this->statusCode = $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource(): ?ResourceInterface
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

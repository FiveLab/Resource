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
 * All presentations should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface PresentationInterface
{
    /**
     * Get the resource of presentation
     *
     * @return ResourceInterface
     */
    public function getResource(): ?ResourceInterface;

    /**
     * Get the status code of presentation
     *
     * @return int
     */
    public function getStatusCode(): int;
}

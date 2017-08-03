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

namespace FiveLab\Component\Resource\Resource\Error;

use FiveLab\Component\Resource\Resource\Href\HrefInterface;
use FiveLab\Component\Resource\Resource\RelatedResourceInterface;
use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * All error resources should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ErrorResourceInterface extends ResourceInterface, RelatedResourceInterface
{
    /**
     * Get the message of error.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get the reason of error.
     *
     * @return int|string
     */
    public function getReason();

    /**
     * Get the path of error.
     *
     * @return string
     */
    public function getPath(): ?string;

    /**
     * Get the identifier of error.
     *
     * @return int|string
     */
    public function getIdentifier();

    /**
     * Get the attributes of this error.
     *
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Add relation to help resource
     *
     * @param HrefInterface $href
     */
    public function addHelp(HrefInterface $href): void;
}

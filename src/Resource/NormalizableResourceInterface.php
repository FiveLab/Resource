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

namespace FiveLab\Component\Resource\Resource;

/**
 * Mark resource as normalizable.
 *
 * @note: you must register additional listener!
 *
 * @see \FiveLab\Component\Resource\Resource\EventListener\NormalizeNormalizableResourcesListener
 */
interface NormalizableResourceInterface extends ResourceInterface
{
    /**
     * Call to this method after denormalize data to resource object.
     * In this method you can normalize all data before validation or next processing.
     *
     * As an example:
     * <pre>
     *      {
     *          "phone": "+1 (050) 123-45-67"
     *      }
     * </pre>
     * You can normalize this value to: "10501234567"
     */
    public function normalize(): void;
}

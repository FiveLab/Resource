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

namespace FiveLab\Component\Resource\Resource\EventListener;

use FiveLab\Component\Resource\Resource\NormalizableResourceInterface;
use FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent;

/**
 * Listener for normalize normalizable resources.
 */
class NormalizeNormalizableResourcesListener
{
    /**
     * Call to this method after denormalize
     *
     * @param AfterDenormalizationEvent $event
     */
    public function onAfterDenormalize(AfterDenormalizationEvent $event): void
    {
        $resource = $event->getResource();

        if ($resource instanceof NormalizableResourceInterface) {
            $resource->normalize();
        }
    }
}

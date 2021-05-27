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

namespace FiveLab\Component\Resource\Serializer;

/**
 * The list of available events on serialization processes.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
final class SerializationEvents
{
    /**
     * Call to this event before normalize object to array
     *
     * @see \FiveLab\Component\Resource\Serializer\Events\BeforeNormalizationEvent
     */
    public const BEFORE_NORMALIZATION = 'resource.serializer.before_normalization';

    /**
     * Call to this event after success normalize object to array
     *
     * @see \FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent
     */
    public const AFTER_NORMALIZATION = 'resource.serializer.after_normalization';

    /**
     * Call to this event before denormalize data to resource object
     *
     * @see \FiveLab\Component\Resource\Serializer\Events\BeforeDenormalizationEvent
     */
    public const BEFORE_DENORMALIZATION = 'resource.serializer.before_denormalization';

    /**
     * Call to this event  after denormalize data to resource object
     *
     * @see \FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent
     */
    public const AFTER_DENORMALIZATION = 'resource.serializer.after_denormalization';
}

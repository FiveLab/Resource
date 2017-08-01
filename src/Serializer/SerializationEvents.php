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
     * @see BeforeNormalizationEvent
     */
    const BEFORE_NORMALIZATION = 'fivelab.serializer.normalization.before';

    /**
     * Call to this event after success normalize object to array
     *
     * @see AfterNormalizationEvent
     */
    const AFTER_NORMALIZATION = 'fivelab.serializer.normalization.after';
}

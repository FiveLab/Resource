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

namespace FiveLab\Component\Resource\Serializer\Context\Collector;

use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;

/**
 * All serialization context collectors should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface SerializationContextCollectorInterface
{
    /**
     * Collect context
     *
     * @return ResourceSerializationContext
     */
    public function collect(): ResourceSerializationContext;
}

<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializer\Context;

/**
 * The mutable serialization context.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class MutableSerializationContext extends ResourceSerializationContext
{
    /**
     * Set the new key-value to context
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return MutableSerializationContext
     */
    public function set(string $key, $value): MutableSerializationContext
    {
        $cloned = clone $this;

        $cloned->payload[$key] = $value;

        return $cloned;
    }

    /**
     * Merge serialization context
     *
     * @param ResourceSerializationContext $context
     *
     * @return MutableSerializationContext
     */
    public function merge(ResourceSerializationContext $context): MutableSerializationContext
    {
        $cloned = clone $this;

        $cloned->payload = array_merge($cloned->payload, $context->payload);

        return $cloned;
    }

    /**
     * Copy context
     *
     * @return ResourceSerializationContext
     */
    public function copy(): ResourceSerializationContext
    {
        return new ResourceSerializationContext($this->payload);
    }
}

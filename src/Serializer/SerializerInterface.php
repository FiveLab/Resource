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
 * All serializers should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface SerializerInterface
{
    /**
     * Serializes data in the appropriate format.
     *
     * @param mixed  $data
     * @param string $format
     * @param array  $context
     *
     * @return string
     */
    public function serialize($data, $format, array $context = array());

    /**
     * Deserializes data into the given type.
     *
     * @param mixed  $data
     * @param string $type
     * @param string $format
     * @param array  $context
     *
     * @return object
     */
    public function deserialize($data, $type, $format, array $context = array());
}

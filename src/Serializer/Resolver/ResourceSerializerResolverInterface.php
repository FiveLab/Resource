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

namespace FiveLab\Component\Resource\Serializer\Resolver;

use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;

/**
 * All resource serializer resolver's should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceSerializerResolverInterface
{
    /**
     * Try resolve the serializer for media type
     *
     * @param string $mediaType
     *
     * @return ResourceSerializerInterface
     *
     * @throws ResourceSerializerNotFoundException
     */
    public function resolveByMediaType(string $mediaType): ResourceSerializerInterface;

    /**
     * Try resolve the serializer from media types
     *
     * @param array  $mediaTypes
     * @param string $acceptMediaType
     *
     * @return ResourceSerializerInterface
     *
     * @throws ResourceSerializerNotFoundException
     */
    public function resolveByMediaTypes(array $mediaTypes, &$acceptMediaType): ResourceSerializerInterface;
}

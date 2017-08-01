<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializer\Resolver;

/**
 * All resource serializer supportable should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceSerializerSupportableInterface
{
    /**
     * Is support normalize the resource object to specified format?
     *
     * @param string $mediaType
     *
     * @return bool
     */
    public function supports(string $mediaType): bool;
}

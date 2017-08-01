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

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;

/**
 * All resource normalizers should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceSerializerInterface
{
    /**
     * Serialize the resource for return to client
     *
     * @param ResourceInterface            $resource
     * @param ResourceSerializationContext $context
     *
     * @return string
     */
    public function serialize(ResourceInterface $resource, ResourceSerializationContext $context): string;

    /**
     * Deserialize the data passed from client to resource
     *
     * @param string                       $data
     * @param string                       $resourceClass
     * @param ResourceSerializationContext $context
     *
     * @return ResourceInterface
     */
    public function deserialize(
        string $data,
        string $resourceClass,
        ResourceSerializationContext $context
    ): ResourceInterface;
}

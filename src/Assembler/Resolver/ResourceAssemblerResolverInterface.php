<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Assembler\Resolver;

use FiveLab\Component\Resource\Assembler\ResourceAssemblerInterface;

/**
 * All assembler resources should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceAssemblerResolverInterface
{
    /**
     * Resolve the assembler by object and resource classes
     *
     * @param string $objectClass
     * @param string $resourceClass
     *
     * @return ResourceAssemblerInterface
     *
     * @throws ResourceAssemblerNotFoundException
     */
    public function resolve(string $objectClass, string $resourceClass): ResourceAssemblerInterface;
}

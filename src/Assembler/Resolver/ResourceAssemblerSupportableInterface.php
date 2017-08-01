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

/**
 * All resource assembler supportable should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceAssemblerSupportableInterface
{
    /**
     * Is support assembly resource from object by classes?
     *
     * @param string $objectClass
     * @param string $resourceClass
     *
     * @return bool
     */
    public function supports(string $objectClass, string $resourceClass): bool;
}

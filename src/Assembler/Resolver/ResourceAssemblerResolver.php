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
 * Resolve resource assembler.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceAssemblerResolver implements ResourceAssemblerResolverInterface
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * Add the resource assembler to registry
     *
     * @param ResourceAssemblerSupportableInterface $supportable
     * @param ResourceAssemblerInterface            $assembler
     */
    public function add(ResourceAssemblerSupportableInterface $supportable, ResourceAssemblerInterface $assembler): void
    {
        $this->map[] = [$supportable, $assembler];
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(string $objectClass, string $resourceClass): ResourceAssemblerInterface
    {
        /** @var ResourceAssemblerSupportableInterface $supportable */
        foreach ($this->map as [$supportable, $assembler]) {
            if ($supportable->supports($objectClass, $resourceClass)) {
                return $assembler;
            }
        }

        throw new ResourceAssemblerNotFoundException(sprintf(
            'Not found assembler for resource by class "%s" and object by class "%s".',
            $resourceClass,
            $objectClass
        ));
    }
}

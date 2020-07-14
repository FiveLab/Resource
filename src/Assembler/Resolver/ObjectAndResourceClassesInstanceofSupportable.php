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

namespace FiveLab\Component\Resource\Assembler\Resolver;

/**
 * The supportable for check object and resource classes.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ObjectAndResourceClassesInstanceofSupportable implements ResourceAssemblerSupportableInterface
{
    /**
     * @var string
     */
    private $objectClass;

    /**
     * @var string
     */
    private $resourceClass;

    /**
     * Constructor.
     *
     * @param string $objectClass
     * @param string $resourceClass
     */
    public function __construct(string $objectClass, string $resourceClass)
    {
        $this->objectClass = $objectClass;
        $this->resourceClass = $resourceClass;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $objectClass, string $resourceClass): bool
    {
        return \is_a($objectClass, $this->objectClass, true) && \is_a($resourceClass, $this->resourceClass, true);
    }
}

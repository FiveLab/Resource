<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Assembler;

use FiveLab\Component\Resource\Assembler\Context\AssembleContext;
use FiveLab\Component\Resource\Resource\ResourceCollection;
use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * All resource assemblers should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ResourceAssemblerInterface
{
    /**
     * Assembly resource from object
     *
     * @param object          $entity
     * @param AssembleContext $context
     *
     * @return ResourceInterface
     */
    public function toResource($entity, AssembleContext $context = null): ResourceInterface;

    /**
     * Assembly resources from iterator
     *
     * @param \Traversable    $entities
     * @param AssembleContext $context
     *
     * @return ResourceCollection|ResourceInterface[]
     */
    public function toResources(\Traversable $entities, AssembleContext $context = null): ResourceCollection;
}

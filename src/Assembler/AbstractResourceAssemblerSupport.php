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

namespace FiveLab\Component\Resource\Assembler;

use FiveLab\Component\Resource\Assembler\Context\AssembleContext;
use FiveLab\Component\Resource\Resource\ResourceCollection;
use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * Abstract class for support assembly resources.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
abstract class AbstractResourceAssemblerSupport implements ResourceAssemblerInterface
{
    /**
     * {@inheritdoc}
     */
    public function toResource(object $entity, AssembleContext $context = null): ResourceInterface
    {
        if (!$context) {
            $context = new AssembleContext([]);
        }

        return $this->convertToResource($entity, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function toResources(\Traversable $entities, AssembleContext $context = null): ResourceCollection
    {
        $resources = [];

        foreach ($entities as $entity) {
            $resources[] = $this->toResource($entity, $context);
        }

        return new ResourceCollection(...$resources);
    }

    /**
     * You should override this method for convert the entity to resource.
     *
     * @param object          $entity
     * @param AssembleContext $context
     *
     * @return ResourceInterface
     */
    abstract protected function convertToResource(object $entity, AssembleContext $context): ResourceInterface;
}

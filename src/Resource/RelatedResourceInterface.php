<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Resource;

use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;

/**
 * The resources which exist relation to any actions or operations should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface RelatedResourceInterface
{
    /**
     * Add the relation to resource
     *
     * @param RelationInterface $relation
     */
    public function addRelation(RelationInterface $relation): void;

    /**
     * Get the relation collection
     *
     * @return RelationCollection|RelationInterface[]
     */
    public function getRelations(): RelationCollection;

    /**
     * Remove relation
     *
     * @param RelationInterface $relation
     */
    public function removeRelation(RelationInterface $relation): void;
}

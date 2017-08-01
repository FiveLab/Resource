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

namespace FiveLab\Component\Resource\Resource;

use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;

/**
 * The abstract class for support resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
abstract class AbstractResourceSupport implements ResourceInterface, RelatedResourceInterface
{
    /**
     * @var \SplObjectStorage|RelationInterface[]
     */
    private $relations;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->relations = new \SplObjectStorage();
    }

    /**
     * {@inheritdoc}
     */
    public function addRelation(RelationInterface $relation): void
    {
        $this->relations->attach($relation);
    }

    /**
     * {@inheritdoc}
     */
    public function getRelations(): RelationCollection
    {
        return new RelationCollection(...iterator_to_array($this->relations));
    }

    /**
     * {@inheritdoc}
     */
    public function removeRelation(RelationInterface $relation): void
    {
        $this->relations->detach($relation);
    }
}

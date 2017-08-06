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

namespace FiveLab\Component\Resource\Resource;

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;

/**
 * The abstract class for support resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
abstract class AbstractResourceSupport implements ResourceInterface, RelatedResourceInterface, ActionedResourceInterface
{
    /**
     * @var \SplObjectStorage|RelationInterface[]
     */
    private $relations;

    /**
     * @var \SplObjectStorage|ActionInterface[]
     */
    private $actions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->relations = new \SplObjectStorage();
        $this->actions = new \SplObjectStorage();
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

    /**
     * {@inheritdoc}
     */
    public function addAction(ActionInterface $action): void
    {
        $this->actions->attach($action);
    }

    /**
     * {@inheritdoc}
     */
    public function getActions(): ActionCollection
    {
        return new ActionCollection(...iterator_to_array($this->actions));
    }

    /**
     * {@inheritdoc}
     */
    public function removeAction(ActionInterface $action): void
    {
        $this->actions->detach($action);
    }
}

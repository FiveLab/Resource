<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Resource\Relation;

/**
 * The collection for store relations.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationCollection implements \Iterator, \Countable
{
    /**
     * @var array|RelationInterface[]
     */
    private $relations;

    /**
     * Constructor.
     *
     * @param RelationInterface[] ...$relations
     */
    public function __construct(RelationInterface ...$relations)
    {
        $this->relations = func_get_args();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->relations);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->relations);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->relations);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return key($this->relations) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->relations);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->relations);
    }
}

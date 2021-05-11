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

namespace FiveLab\Component\Resource\Resource\Relation;

/**
 * The collection for store relations.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 *
 * @implements \IteratorAggregate<RelationInterface>
 */
class RelationCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array|RelationInterface[]
     */
    private array $relations;

    /**
     * Constructor.
     *
     * @param RelationInterface ...$relations
     */
    public function __construct(RelationInterface ...$relations)
    {
        $this->relations = func_get_args();
    }

    /**
     * {@inheritdoc}
     *
     * @return \ArrayIterator|RelationInterface[]
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->relations);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->relations);
    }
}

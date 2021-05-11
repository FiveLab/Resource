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

namespace FiveLab\Component\Resource\Resource\Action;

/**
 * The collection for store resource actions.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 *
 * @implements \IteratorAggregate<ActionInterface>
 */
class ActionCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array<ActionInterface>
     */
    private array $actions;

    /**
     * Constructor.
     *
     * @param ActionInterface ...$actions
     */
    public function __construct(ActionInterface ...$actions)
    {
        $this->actions = $actions;
    }

    /**
     * {@inheritdoc}
     *
     * @return \ArrayIterator<ActionInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->actions);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->actions);
    }
}

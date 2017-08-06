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
 */
class ActionCollection implements \Iterator, \Countable
{
    /**
     * @var array
     */
    private $actions;

    /**
     * Constructor.
     *
     * @param ActionInterface[] ...$actions
     */
    public function __construct(ActionInterface ...$actions)
    {
        $this->actions = $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function current(): ActionInterface
    {
        return current($this->actions);
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        next($this->actions);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->actions);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return key($this->actions) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->actions);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->actions);
    }
}

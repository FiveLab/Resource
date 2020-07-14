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

namespace FiveLab\Component\Resource\Resource\Error;

/**
 * The collection for store child errors.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollection extends ErrorResource implements \IteratorAggregate, \Countable
{
    /**
     * @var array|ErrorResourceInterface[]
     */
    private $errors = [];

    /**
     * Add errors to collection
     *
     * @param ErrorResourceInterface ...$errors
     */
    public function addErrors(ErrorResourceInterface ...$errors): void
    {
        $this->errors = array_merge($this->errors, $errors);
    }

    /**
     * {@inheritdoc}
     *
     * @return \ArrayIterator|ErrorResourceInterface[]
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->errors);
    }
}

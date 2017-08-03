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
class ErrorCollection extends ErrorResource implements \Iterator, \Countable
{
    /**
     * @var ErrorResourceInterface[]
     */
    private $errors;

    /**
     * Add errors to collection
     *
     * @param ErrorResourceInterface[] ...$errors
     */
    public function addErrors(ErrorResourceInterface ...$errors): void
    {
        if (!$this->errors) {
            $this->errors = [];
        }

        $this->errors = array_merge($this->errors, $errors);
    }

    /**
     * {@inheritdoc}
     */
    public function current(): ErrorResourceInterface
    {
        return current($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        next($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return key($this->errors) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->errors);
    }
}

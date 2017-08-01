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

/**
 * The collection for store resources.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceCollection extends AbstractResourceSupport implements \Iterator, \Countable
{
    /**
     * @var ResourceInterface[]
     */
    private $resources;

    /**
     * Constructor.
     *
     * @param ResourceInterface[] ...$resources
     */
    public function __construct(ResourceInterface ...$resources)
    {
        $this->resources = func_get_args();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return key($this->resources) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->resources);
    }
}

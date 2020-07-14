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

/**
 * The collection for store resources.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceCollection extends AbstractResourceSupport implements \IteratorAggregate, \Countable
{
    /**
     * @var ResourceInterface[]
     */
    private $resources;

    /**
     * Constructor.
     *
     * @param ResourceInterface ...$resources
     */
    public function __construct(ResourceInterface ...$resources)
    {
        parent::__construct();

        $this->resources = func_get_args();
    }

    /**
     * {@inheritdoc}
     *
     * @return \ArrayIterator|ResourceInterface[]
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->resources);
    }
}

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
 * Paginated resource collection.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedResourceCollection extends ResourceCollection
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $total;

    /**
     * Constructor.
     *
     * @param int                 $page
     * @param int                 $limit
     * @param int                 $total
     * @param ResourceInterface[] ...$resources
     */
    public function __construct(int $page, int $limit, int $total, ResourceInterface ...$resources)
    {
        parent::__construct(...$resources);

        $this->page = $page;
        $this->limit = $limit;
        $this->total = $total;
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Get the count of total items
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}

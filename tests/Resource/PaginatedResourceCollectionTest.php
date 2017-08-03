<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource;

use FiveLab\Component\Resource\Resource\PaginatedResourceCollection;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PaginatedResourceCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $resource1 = $this->createMock(ResourceInterface::class);
        $resource2 = $this->createMock(ResourceInterface::class);

        $collection = new PaginatedResourceCollection(2, 10, 22, $resource1, $resource2);

        self::assertEquals(2, $collection->getPage());
        self::assertEquals(10, $collection->getLimit());
        self::assertEquals(22, $collection->getTotal());

        self::assertCount(2, $collection);
        self::assertEquals([$resource1, $resource2], iterator_to_array($collection));
    }
}

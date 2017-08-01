<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource\Relation;

use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $relation1 = $this->createMock(RelationInterface::class);
        $relation2 = $this->createMock(RelationInterface::class);
        
        $collection = new RelationCollection($relation1, $relation2);
        
        self::assertCount(2, $collection);
        
        self::assertEquals([$relation1, $relation2], iterator_to_array($collection));
    }
}

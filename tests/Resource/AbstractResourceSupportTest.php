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

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use FiveLab\Component\Resource\Resource\Relation\RelationInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AbstractResourceSupportTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessManipulateWithRelations(): void
    {
        $resource = new TestedResourceSupport();

        self::assertCount(0, $resource->getRelations());

        $relation = $this->createMock(RelationInterface::class);
        $resource->addRelation($relation);

        self::assertCount(1, $resource->getRelations());
        self::assertEquals(new RelationCollection($relation), $resource->getRelations());

        $resource->removeRelation($relation);
        self::assertCount(0, $resource->getRelations());
    }

    /**
     * @test
     */
    public function shouldSuccessManipulateWithActions(): void
    {
        $resource = new TestedResourceSupport();

        self::assertCount(0, $resource->getActions());

        $action = $this->createMock(ActionInterface::class);
        $resource->addAction($action);

        self::assertCount(1, $resource->getActions());
        self::assertEquals(new ActionCollection($action), $resource->getActions());

        $resource->removeAction($action);
        self::assertCount(0, $resource->getActions());
    }
}

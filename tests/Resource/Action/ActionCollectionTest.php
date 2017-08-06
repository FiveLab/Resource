<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource\Action;

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ActionCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $action1 = $this->createMock(ActionInterface::class);
        $action2 = $this->createMock(ActionInterface::class);

        $collection = new ActionCollection($action1, $action2);

        self::assertCount(2, $collection);
        self::assertEquals([$action1, $action2], iterator_to_array($collection));
    }
}

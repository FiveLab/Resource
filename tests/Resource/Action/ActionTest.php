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

use FiveLab\Component\Resource\Resource\Action\Action;
use FiveLab\Component\Resource\Resource\Action\Method;
use FiveLab\Component\Resource\Resource\Href\Href;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ActionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $action = new Action('some', new Href('/some'), Method::post(), ['attr']);

        self::assertEquals('some', $action->getName());
        self::assertEquals(new Href('/some'), $action->getHref());
        self::assertEquals(Method::post(), $action->getMethod());
        self::assertEquals(['attr'], $action->getAttributes());
    }

    /**
     * @test
     */
    public function shouldSuccessChangeHref(): void
    {
        $action = new Action('some', new Href('/some'), Method::post());
        $action->setHref(new Href('/some-path'));

        self::assertEquals(new Href('/some-path'), $action->getHref());
    }

    /**
     * @test
     */
    public function shouldSuccessChangeMethod(): void
    {
        $action = new Action('some', new Href('/some'), Method::post());
        $action->setMethod(Method::put());

        self::assertEquals(Method::put(), $action->getMethod());
    }

    /**
     * @test
     */
    public function shouldSuccessChangeAttributes(): void
    {
        $action = new Action('some', new Href('/some'), Method::post(), ['attr']);
        $action->setAttributes(['some' => 'bar']);

        self::assertEquals(['some' => 'bar'], $action->getAttributes());
    }
}

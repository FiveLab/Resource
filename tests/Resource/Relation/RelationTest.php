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

use FiveLab\Component\Resource\Resource\Href\HrefInterface;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class RelationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $href = $this->createMock(HrefInterface::class);

        $relation = new Relation('some', $href, ['attr' => 'value']);

        self::assertEquals('some', $relation->getName());
        self::assertEquals($href, $relation->getHref());
        self::assertEquals(['attr' => 'value'], $relation->getAttributes());
    }

    /**
     * @test
     */
    public function shouldSuccessChangeParameters(): void
    {
        $href = $this->createMock(HrefInterface::class);
        $newHref = $this->createMock(HrefInterface::class);

        $relation = new Relation('some', $href, ['attr' => 'value']);

        $relation->setHref($newHref);
        $relation->setAttributes(['new-attr' => 'new-value']);

        self::assertEquals($newHref, $relation->getHref());
        self::assertEquals(['new-attr' => 'new-value'], $relation->getAttributes());
    }
}

<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource\Error;

use FiveLab\Component\Resource\Resource\Error\ErrorCollection;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $collection = new ErrorCollection(
            'message',
            'reason',
            '/path',
            ['attr' => 'value'],
            'identifier'
        );

        $collection->addErrors(new ErrorResource('some1'), new ErrorResource('some2'));

        self::assertEquals('message', $collection->getMessage());
        self::assertEquals('reason', $collection->getReason());
        self::assertEquals('/path', $collection->getPath());
        self::assertEquals(['attr' => 'value'], $collection->getAttributes());
        self::assertEquals('identifier', $collection->getIdentifier());

        self::assertCount(2, $collection);
        self::assertEquals([new ErrorResource('some1'), new ErrorResource('some2')], iterator_to_array($collection));
    }
}

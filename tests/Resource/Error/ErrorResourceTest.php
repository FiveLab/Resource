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

use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use FiveLab\Component\Resource\Resource\Href\Href;
use FiveLab\Component\Resource\Resource\Relation\Relation;
use FiveLab\Component\Resource\Resource\Relation\RelationCollection;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorResourceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $error = new ErrorResource(
            'message',
            'reason',
            '/some',
            ['var' => 'value'],
            'identifier'
        );

        $error->addHelp(new Href('/some'));

        self::assertEquals('message', $error->getMessage());
        self::assertEquals('reason', $error->getReason());
        self::assertEquals('/some', $error->getPath());
        self::assertEquals(['var' => 'value'], $error->getAttributes());
        self::assertEquals('identifier', $error->getIdentifier());

        self::assertEquals(
            new RelationCollection(new Relation('help', new Href('/some'))),
            $error->getRelations()
        );
    }
}

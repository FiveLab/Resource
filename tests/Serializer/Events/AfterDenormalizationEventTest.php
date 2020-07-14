<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Events;

use FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent;
use FiveLab\Component\Resource\Tests\Serializer\TestedClassForSerialization;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AfterDenormalizationEventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $event = new AfterDenormalizationEvent(['foo' => 'bar'], new TestedClassForSerialization(), 'json', ['any']);

        self::assertEquals(['foo' => 'bar'], $event->getData());
        self::assertEquals(new TestedClassForSerialization(), $event->getResource());
        self::assertEquals('json', $event->getFormat());
        self::assertEquals(['any'], $event->getContext());
    }
}

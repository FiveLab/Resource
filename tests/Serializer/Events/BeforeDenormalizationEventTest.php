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

use FiveLab\Component\Resource\Serializer\Events\BeforeDenormalizationEvent;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class BeforeDenormalizationEventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $event = new BeforeDenormalizationEvent(['foo' => 'bar'], 'SomeClass', 'json', ['any']);

        self::assertEquals(['foo' => 'bar'], $event->getData());
        self::assertEquals('SomeClass', $event->getType());
        self::assertEquals('json', $event->getFormat());
        self::assertEquals(['any'], $event->getContext());
    }
}

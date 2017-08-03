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

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Events\AfterNormalizationEvent;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AfterNormalizationEventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $event = new AfterNormalizationEvent($resource, ['normalized'], 'json', ['context']);

        self::assertEquals($resource, $event->getResource());
        self::assertEquals(['normalized'], $event->getNormalizedData());
        self::assertEquals('json', $event->getFormat());
        self::assertEquals(['context'], $event->getContext());
    }
}

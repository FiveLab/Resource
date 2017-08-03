<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Context\Collector;

use FiveLab\Component\Resource\Serializer\Context\Collector\SerializationContextCollectorChain;
use FiveLab\Component\Resource\Serializer\Context\Collector\SerializationContextCollectorInterface;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class SerializationContextCollectorChainTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCollect(): void
    {
        $collector1 = $this->createMock(SerializationContextCollectorInterface::class);
        $collector2 = $this->createMock(SerializationContextCollectorInterface::class);

        $chainCollector = new SerializationContextCollectorChain();

        $chainCollector->add($collector1);
        $chainCollector->add($collector2);

        $collector1->expects(self::once())
            ->method('collect')
            ->willReturn(new ResourceSerializationContext(['bar' => 'foo']));

        $collector2->expects(self::once())
            ->method('collect')
            ->willReturn(new ResourceSerializationContext([]));

        $context = $chainCollector->collect();

        self::assertEquals(new ResourceSerializationContext(['bar' => 'foo']), $context);
    }
}

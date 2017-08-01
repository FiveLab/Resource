<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Context;

use FiveLab\Component\Resource\Serializer\Context\MutableSerializationContext;
use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class MutableSerializationContextTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessSet(): void
    {
        $context = new MutableSerializationContext([]);

        $cloned = $context->set('some', 'bar');
        
        self::assertEquals('bar', $cloned->get('some'));
    }

    /**
     * @test
     */
    public function shouldSuccessMerge(): void
    {
        $context = new MutableSerializationContext([]);
        $childContext = new ResourceSerializationContext(['bar' => 'foo']);
        
        $cloned = $context->merge($childContext);

        self::assertEquals('foo', $cloned->get('bar'));
    }

    /**
     * @test
     */
    public function shouldSuccessCopy(): void
    {
        $context = new MutableSerializationContext(['foo' => 'bar']);
        $copied = $context->copy();

        self::assertEquals(new ResourceSerializationContext(['foo' => 'bar']), $copied);
    }
}

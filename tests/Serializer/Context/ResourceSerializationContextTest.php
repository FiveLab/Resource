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

use FiveLab\Component\Resource\Serializer\Context\ResourceSerializationContext;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceSerializationContextTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $context = new ResourceSerializationContext([
            'some' => 'qwerty',
            'bar' => 'foo',
        ]);

        self::assertEquals('qwerty', $context->get('some'));
        self::assertEquals('foo', $context->get('bar'));

        // Get with default value
        self::assertEquals('bar', $context->get('foo', 'bar'));

        // Get without default value
        self::assertNull($context->get('foo-bar'));
    }
}

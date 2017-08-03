<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Resolver;

use FiveLab\Component\Resource\Serializer\Resolver\AcceptFormatSupportable;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AcceptFormatSupportableTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessAccept(): void
    {
        $supportable = new AcceptFormatSupportable(['application/json', 'text/json']);

        self::assertTrue($supportable->supports('Class1', 'application/json'));
        self::assertTrue($supportable->supports('Class1', 'text/json'));
        self::assertFalse($supportable->supports('Class1', 'text/xml'));
    }

    /**
     * @test
     */
    public function shouldNotSupportIfClassNotSupported(): void
    {
        $supportable = new AcceptFormatSupportable(['application/json'], [], [NotSupportedClass::class]);

        self::assertFalse($supportable->supports(NotSupportedClass::class, 'application/json'));
    }

    /**
     * @test
     */
    public function shouldSupportIfClassIsSupported(): void
    {
        $supportable = new AcceptFormatSupportable(['application/xml'], [SupportedClass::class]);

        self::assertTrue($supportable->supports(SupportedClass::class, 'application/xml'));
    }

    /**
     * @test
     */
    public function shouldNotSupportIfPassNotSupportedClassToSupported(): void
    {
        $supportable = new AcceptFormatSupportable(['application/xml'], [SupportedClass::class]);

        self::assertFalse($supportable->supports(NotSupportedClass::class, 'application/xml'));
    }
}

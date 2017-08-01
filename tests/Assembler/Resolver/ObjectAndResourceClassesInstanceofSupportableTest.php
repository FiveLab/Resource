<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Assembler\Resolver;

use FiveLab\Component\Resource\Assembler\Resolver\ObjectAndResourceClassesInstanceofSupportable;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ObjectAndResourceClassesInstanceofSupportableTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessSupport(): void
    {
        $supportable = new ObjectAndResourceClassesInstanceofSupportable(__CLASS__, \stdClass::class);
        $support = $supportable->supports(__CLASS__, \stdClass::class);

        self::assertTrue($support);
    }

    /**
     * @test
     */
    public function shouldNotSupportIfObjectClassIsInvalid(): void
    {
        $supportable = new ObjectAndResourceClassesInstanceofSupportable(__CLASS__, \stdClass::class);
        $support = $supportable->supports(\stdClass::class, \stdClass::class);

        self::assertFalse($support);
    }

    /**
     * @test
     */
    public function shouldNotSupportIfResourceClassIsInvalid(): void
    {
        $supportable = new ObjectAndResourceClassesInstanceofSupportable(__CLASS__, \stdClass::class);
        $support = $supportable->supports(__CLASS__, __CLASS__);

        self::assertFalse($support);
    }
}

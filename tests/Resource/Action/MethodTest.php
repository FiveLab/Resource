<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource\Action;

use FiveLab\Component\Resource\Resource\Action\Method;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class MethodTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreatePost(): void
    {
        $method = Method::post();

        self::assertEquals('POST', $method->getValue());
    }

    /**
     * @test
     */
    public function shouldSuccessCreatePut(): void
    {
        $method = Method::put();

        self::assertEquals('PUT', $method->getValue());
    }

    /**
     * @test
     */
    public function shouldSuccessCreatePatch(): void
    {
        $method = Method::patch();

        self::assertEquals('PATCH', $method->getValue());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateDelete(): void
    {
        $method = Method::delete();

        self::assertEquals('DELETE', $method->getValue());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateGet(): void
    {
        $method = Method::get();

        self::assertEquals('GET', $method->getValue());
    }

    /**
     * @test
     */
    public function shouldSuccessGetPossibleValues()
    {
        $values = Method::getPossibleValues();

        self::assertEquals([
            Method::POST,
            Method::PUT,
            Method::PATCH,
            Method::DELETE,
            Method::GET,
        ], $values);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfPassInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid method "SOME". Available methods: "POST", "PUT", "PATCH", "DELETE", "GET".');

        new Method('SOME');
    }
}

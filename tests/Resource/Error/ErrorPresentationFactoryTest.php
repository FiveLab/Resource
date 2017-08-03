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

use FiveLab\Component\Resource\Presentation\PresentationInterface;
use FiveLab\Component\Resource\Resource\Error\ErrorPresentationFactory;
use FiveLab\Component\Resource\Resource\Error\ErrorResource;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorPresentationFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $presentation = ErrorPresentationFactory::create(500, 'message', 'reason', 'path', ['attr'], 'identifier');

        self::assertEquals(500, $presentation->getStatusCode());
        self::assertEquals(new ErrorResource('message', 'reason', 'path', ['attr'], 'identifier'), $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateBadRequest(): void
    {
        $this->successCreate('badRequest', 400);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnauthorized(): void
    {
        $this->successCreate('unauthorized', 401);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateForbidden(): void
    {
        $this->successCreate('forbidden', 403);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateNotFound(): void
    {
        $this->successCreate('notFound', 404);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateConflict(): void
    {
        $this->successCreate('conflict', 409);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateGone(): void
    {
        $this->successCreate('gone', 410);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateRequestEntityToLarge(): void
    {
        $this->successCreate('requestEntityToLarge', 413);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnsupportedMediaType(): void
    {
        $this->successCreate('unsupportedMediaType', 415);
    }

    /**
     * @test
     */
    public function shouldSuccessCreateInternalServerError(): void
    {
        $this->successCreate('internalServerError', 500);
    }

    /**
     * Test success create error presentation
     *
     * @param string $methodName
     * @param int    $expectedStatusCode
     */
    private function successCreate(string $methodName, int $expectedStatusCode): void
    {
        $callable = [ErrorPresentationFactory::class, $methodName];

        /** @var PresentationInterface $presentation */
        $presentation = $callable('message', 'reason', 'path', ['attr'], 'identifier');

        self::assertEquals($expectedStatusCode, $presentation->getStatusCode());
        self::assertEquals(new ErrorResource('message', 'reason', 'path', ['attr'], 'identifier'), $presentation->getResource());
    }
}

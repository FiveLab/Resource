<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Presentation;

use FiveLab\Component\Resource\Presentation\PresentationFactory;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PresentationFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        
        $presentation = PresentationFactory::create(200, $resource);
        
        self::assertEquals($resource, $presentation->getResource());
        self::assertEquals(200, $presentation->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateWithoutResource(): void
    {
        $presentation = PresentationFactory::create(200);
        
        self::assertNull($presentation->getResource());
        self::assertEquals(200, $presentation->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateOk(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        
        $presentation = PresentationFactory::ok($resource);

        self::assertEquals(200, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateCreated(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::created($resource);

        self::assertEquals(201, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateCreatedWithoutResource(): void
    {
        $presentation = PresentationFactory::created();

        self::assertEquals(201, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateAccepted(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::accepted($resource);

        self::assertEquals(202, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateAcceptedWithoutResource(): void
    {
        $presentation = PresentationFactory::accepted();

        self::assertEquals(202, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateNonAuthoritativeInformation(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::nonAuthoritativeInformation($resource);

        self::assertEquals(203, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateNoContent(): void
    {
        $presentation = PresentationFactory::noContent();
        
        self::assertEquals(204, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateResetContent(): void
    {
        $presentation = PresentationFactory::resetContent();

        self::assertEquals(205, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateBadRequest(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::badRequest($resource);

        self::assertEquals(400, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateBadRequestWithoutResource(): void
    {
        $presentation = PresentationFactory::badRequest();

        self::assertEquals(400, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnauthorized(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::unauthorized($resource);

        self::assertEquals(401, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnauthorizedWithoutResource(): void
    {
        $presentation = PresentationFactory::unauthorized();

        self::assertEquals(401, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateForbidden(): void
    {
        $resource = $this->createMock(ResourceInterface::class);
        
        $presentation = PresentationFactory::forbidden($resource);
        
        self::assertEquals(403, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateForbiddenWithoutResource(): void
    {
        $presentation = PresentationFactory::forbidden();

        self::assertEquals(403, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateNotFound(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::notFound($resource);

        self::assertEquals(404, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateNotFoundWithoutResource(): void
    {
        $presentation = PresentationFactory::notFound();

        self::assertEquals(404, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateConflict(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::conflict($resource);

        self::assertEquals(409, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateConflictWithoutResource(): void
    {
        $presentation = PresentationFactory::conflict();

        self::assertEquals(409, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateGone(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::gone($resource);

        self::assertEquals(410, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateGoneWithoutResource(): void
    {
        $presentation = PresentationFactory::gone();

        self::assertEquals(410, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateRequestEntityToLarge(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::requestEntityToLarge($resource);

        self::assertEquals(413, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateRequestEntityToLargeWithoutResource(): void
    {
        $presentation = PresentationFactory::requestEntityToLarge();

        self::assertEquals(413, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnsupportedMediaType(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::unsupportedMediaType($resource);

        self::assertEquals(415, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateUnsupportedMediaTypeWithoutResource(): void
    {
        $presentation = PresentationFactory::unsupportedMediaType();

        self::assertEquals(415, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateInternalServerError(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = PresentationFactory::internalServerError($resource);

        self::assertEquals(500, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessInternalServerErrorWithoutResource(): void
    {
        $presentation = PresentationFactory::internalServerError();

        self::assertEquals(500, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }
}

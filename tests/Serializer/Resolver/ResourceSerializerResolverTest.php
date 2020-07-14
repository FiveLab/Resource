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

use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Resolver\ResourceSerializerNotFoundException;
use FiveLab\Component\Resource\Serializer\Resolver\ResourceSerializerResolver;
use FiveLab\Component\Resource\Serializer\Resolver\ResourceSerializerSupportableInterface;
use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceSerializerResolverTest extends TestCase
{
    /**
     * @var ResourceSerializerResolver
     */
    private $resolver;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->resolver = new ResourceSerializerResolver();
    }

    /**
     * @test
     */
    public function shouldSuccessResolveByMediaType(): void
    {
        $supportable1 = $this->createMock(ResourceSerializerSupportableInterface::class);
        $serializer1 = $this->createMock(ResourceSerializerInterface::class);

        $supportable2 = $this->createMock(ResourceSerializerSupportableInterface::class);
        $serializer2 = $this->createMock(ResourceSerializerInterface::class);

        $supportable1->expects(self::once())
            ->method('supports')
            ->with(ResourceInterface::class, 'application/json')
            ->willReturn(false);

        $supportable2->expects(self::once())
            ->method('supports')
            ->with(ResourceInterface::class, 'application/json')
            ->willReturn(true);

        $this->resolver->add($supportable1, $serializer1);
        $this->resolver->add($supportable2, $serializer2);

        $serializer = $this->resolver->resolveByMediaType(ResourceInterface::class, 'application/json');

        self::assertEquals($serializer2, $serializer);
    }

    /**
     * @test
     */
    public function shouldSuccessResolveByMediaTypes(): void
    {
        $supportable1 = $this->createMock(ResourceSerializerSupportableInterface::class);
        $serializer1 = $this->createMock(ResourceSerializerInterface::class);

        $supportable2 = $this->createMock(ResourceSerializerSupportableInterface::class);
        $serializer2 = $this->createMock(ResourceSerializerInterface::class);

        $supportable1->expects(self::exactly(2))
            ->method('supports')
            ->with(ResourceInterface::class, self::logicalOr('application/json', 'application/hal+json'))
            ->willReturnMap([
                [ResourceInterface::class, 'application/json', false],
                [ResourceInterface::class, 'application/hal+json', false],
            ]);

        $supportable2->expects(self::exactly(2))
            ->method('supports')
            ->with(ResourceInterface::class, self::logicalOr('application/json', 'application/hal+json'))
            ->willReturnMap([
                [ResourceInterface::class, 'application/json', true],
                [ResourceInterface::class, 'application/hal+json', false],
            ]);

        $this->resolver->add($supportable1, $serializer1);
        $this->resolver->add($supportable2, $serializer2);

        $serializer = $this->resolver->resolveByMediaTypes(ResourceInterface::class, ['application/hal+json', 'application/json'], $acceptFormat);

        self::assertEquals('application/json', $acceptFormat);
        self::assertEquals($serializer2, $serializer);
    }

    /**
     * @test
     */
    public function shouldFailResolveByMediaTypeIfNotSupport(): void
    {
        $this->expectException(ResourceSerializerNotFoundException::class);
        $this->expectExceptionMessage('Not found serializer for resource for media type "application/xml".');

        $this->resolver->resolveByMediaType(ResourceInterface::class, 'application/xml');
    }

    /**
     * @test
     */
    public function shouldFailResolveByMediaTypesIfNotSupport(): void
    {
        $this->expectException(ResourceSerializerNotFoundException::class);
        $this->expectExceptionMessage('Can\'t resolve resource serializer for any media types: "application/xml", "application/hal+xml".');

        $this->resolver->resolveByMediaTypes(ResourceInterface::class, ['application/xml', 'application/hal+xml'], $acceptFormat);
    }
}

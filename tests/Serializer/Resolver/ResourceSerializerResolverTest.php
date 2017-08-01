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
            ->with('application/json')
            ->willReturn(false);

        $supportable2->expects(self::once())
            ->method('supports')
            ->with('application/json')
            ->willReturn(true);

        $this->resolver->add($supportable1, $serializer1);
        $this->resolver->add($supportable2, $serializer2);

        $serializer = $this->resolver->resolveByMediaType('application/json');

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
            ->with(self::logicalOr('application/json', 'application/hal+json'))
            ->willReturnMap([
                ['application/json', false],
                ['application/hal+json', false]
            ]);

        $supportable2->expects(self::exactly(2))
            ->method('supports')
            ->with(self::logicalOr('application/json', 'application/hal+json'))
            ->willReturnMap([
                ['application/json', true],
                ['application/hal+json', false]
            ]);

        $this->resolver->add($supportable1, $serializer1);
        $this->resolver->add($supportable2, $serializer2);

        $serializer = $this->resolver->resolveByMediaTypes(['application/hal+json', 'application/json'], $acceptFormat);

        self::assertEquals('application/json', $acceptFormat);
        self::assertEquals($serializer2, $serializer);
    }

    /**
     * @test
     *
     * @expectedException \FiveLab\Component\Resource\Serializer\Resolver\ResourceSerializerNotFoundException
     * @expectedExceptionMessage Not found serializer for resource for media type "application/xml".
     */
    public function shouldFailResolveByMediaTypeIfNotSupport(): void
    {
        $this->resolver->resolveByMediaType('application/xml');
    }

    /**
     * @test
     *
     * @expectedException \FiveLab\Component\Resource\Serializer\Resolver\ResourceSerializerNotFoundException
     * @expectedExceptionMessage Can't resolve resource serializer for any media types: "application/xml", "application/hal+xml".
     */
    public function shouldFailResolveByMediaTypesIfNotSupport(): void
    {
        $this->resolver->resolveByMediaTypes(['application/xml', 'application/hal+xml'], $acceptFormat);
    }
}

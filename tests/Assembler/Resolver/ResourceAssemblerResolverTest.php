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

use FiveLab\Component\Resource\Assembler\Resolver\ResourceAssemblerResolver;
use FiveLab\Component\Resource\Assembler\Resolver\ResourceAssemblerSupportableInterface;
use FiveLab\Component\Resource\Assembler\ResourceAssemblerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceAssemblerResolverTest extends TestCase
{
    /**
     * @var ResourceAssemblerResolver
     */
    private $resolver;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->resolver = new ResourceAssemblerResolver();
    }

    /**
     * @test
     */
    public function shouldSuccessSupport(): void
    {
        $assembler1 = $this->createMock(ResourceAssemblerInterface::class);
        $supportable1 = $this->createMock(ResourceAssemblerSupportableInterface::class);

        $assembler2 = $this->createMock(ResourceAssemblerInterface::class);
        $supportable2 = $this->createMock(ResourceAssemblerSupportableInterface::class);

        $this->resolver->add($supportable1, $assembler1);
        $this->resolver->add($supportable2, $assembler2);
        
        $supportable1->expects(self::once())
            ->method('supports')
            ->with(__CLASS__, \stdClass::class)
            ->willReturn(false);

        $supportable2->expects(self::once())
            ->method('supports')
            ->with(__CLASS__, \stdClass::class)
            ->willReturn(true);

        $assembler = $this->resolver->resolve(__CLASS__, \stdClass::class);
        
        self::assertEquals($assembler2, $assembler);
    }

    /**
     * @test
     *
     * @expectedException \FiveLab\Component\Resource\Assembler\Resolver\ResourceAssemblerNotFoundException
     */
    public function shouldThrowExceptionIfNotSupports(): void
    {
        $this->resolver->resolve(__CLASS__, \stdClass::class);
    }
}
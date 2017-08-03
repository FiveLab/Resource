<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Assembler;

use FiveLab\Component\Resource\Resource\ResourceCollection;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AbstractResourceAssemblerSupportTest extends TestCase
{
    /**
     * @var TestedResourceAssembler
     */
    private $assembler;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->assembler = new TestedResourceAssembler();
    }

    /**
     * @test
     */
    public function shouldSuccessConvertToResource(): void
    {
        $resource = $this->assembler->toResource(new \stdClass());

        self::assertEquals(new TestedResource(), $resource);
    }

    /**
     * @test
     */
    public function shouldSuccessConvertToResources(): void
    {
        $resources = $this->assembler->toResources(new \ArrayIterator([new \stdClass(), new \stdClass()]));

        self::assertEquals(new ResourceCollection(new TestedResource(), new TestedResource()), $resources);
    }
}

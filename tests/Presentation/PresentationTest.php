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

use FiveLab\Component\Resource\Presentation\Presentation;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PresentationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessCreate(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $presentation = new Presentation(200, $resource);

        self::assertEquals(200, $presentation->getStatusCode());
        self::assertEquals($resource, $presentation->getResource());
    }

    /**
     * @test
     */
    public function shouldSuccessCreateWithoutResource(): void
    {
        $presentation = new Presentation(204);

        self::assertEquals(204, $presentation->getStatusCode());
        self::assertNull($presentation->getResource());
    }
}

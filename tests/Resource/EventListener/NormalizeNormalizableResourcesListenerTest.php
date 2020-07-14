<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Resource\EventListener;

use FiveLab\Component\Resource\Resource\EventListener\NormalizeNormalizableResourcesListener;
use FiveLab\Component\Resource\Resource\NormalizableResourceInterface;
use FiveLab\Component\Resource\Resource\ResourceInterface;
use FiveLab\Component\Resource\Serializer\Events\AfterDenormalizationEvent;
use PHPUnit\Framework\TestCase;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class NormalizeNormalizableResourcesListenerTest extends TestCase
{
    /**
     * @var NormalizeNormalizableResourcesListener
     */
    private $listener;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->listener = new NormalizeNormalizableResourcesListener();
    }

    /**
     * @test
     */
    public function shouldSuccessNormalize(): void
    {
        // @codingStandardsIgnoreStart
        $resource = new class() implements NormalizableResourceInterface {
            public $field = 'foo';

            public function normalize(): void
            {
                $this->field = 'bar';
            }
        };
        // @codingStandardsIgnoreEnd

        $event = new AfterDenormalizationEvent([], $resource, '', []);
        $this->listener->onAfterDenormalize($event);

        self::assertEquals('bar', $resource->field);
    }

    /**
     * @test
     */
    public function shouldNotNormalizeNotNormalizableResource(): void
    {
        // @codingStandardsIgnoreStart
        $resource = new class() implements ResourceInterface {
            public $field = 'foo';

            public function normalize(): void
            {
                $this->field = 'bar';
            }
        };
        // @codingStandardsIgnoreEnd

        $event = new AfterDenormalizationEvent([], $resource, '', []);
        $this->listener->onAfterDenormalize($event);

        self::assertEquals('foo', $resource->field);
    }
}

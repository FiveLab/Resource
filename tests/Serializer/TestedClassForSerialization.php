<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer;

use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class TestedClassForSerialization implements ResourceInterface
{
    /**
     * @var string
     */
    public $fieldFoo;

    /**
     * @var array
     */
    public $fieldBar;

    /**
     * Constructor.
     *
     * @param string         $fieldFoo
     * @param array|string[] $fieldBar
     */
    public function __construct(string $fieldFoo = 'field1', array $fieldBar = ['field2'])
    {
        $this->fieldFoo = $fieldFoo;
        $this->fieldBar = $fieldBar;
    }
}

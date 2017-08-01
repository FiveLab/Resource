<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Tests\Serializer\Normalizer;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class CustomObjectForNormalize
{
    /**
     * @var string
     */
    public $field1 = 'value1';

    /**
     * @var array
     */
    public $field2 = ['value2'];
}

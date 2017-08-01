<?php

declare(strict_types=1);

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializer;

use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

/**
 * All serializers should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface SerializerInterface extends SymfonySerializerInterface
{
}

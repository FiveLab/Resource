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

use FiveLab\Component\Resource\Assembler\AbstractResourceAssemblerSupport;
use FiveLab\Component\Resource\Assembler\Context\AssembleContext;
use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class TestedResourceAssembler extends AbstractResourceAssemblerSupport
{
    /**
     * {@inheritdoc}
     */
    protected function convertToResource(object $entity, AssembleContext $context): ResourceInterface
    {
        return new TestedResource();
    }
}

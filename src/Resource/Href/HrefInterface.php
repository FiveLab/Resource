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

namespace FiveLab\Component\Resource\Resource\Href;

/**
 * All href's of relations should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface HrefInterface
{
    /**
     * Get the path
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Is href templated?
     *
     * @return bool
     */
    public function isTemplated(): bool;
}

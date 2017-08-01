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
 * Default href value for relation.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Href implements HrefInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $templated;

    /**
     * Constructor.
     *
     * @param string $path
     * @param bool   $templated
     */
    public function __construct(string $path, bool $templated = false)
    {
        $this->path = $path;
        $this->templated = $templated;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Is href templated?
     *
     * @return bool
     */
    public function isTemplated(): bool
    {
        return $this->templated;
    }
}

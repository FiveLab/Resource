<?php

declare(strict_types = 1);

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Resource\Relation;

use FiveLab\Component\Resource\Resource\Href\HrefInterface;

/**
 * The default relation for resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Relation implements RelationInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var HrefInterface
     */
    private HrefInterface $href;

    /**
     * @var array<string, mixed>
     */
    private array $attributes;

    /**
     * Constructor.
     *
     * @param string               $name
     * @param HrefInterface        $href
     * @param array<string, mixed> $attributes
     */
    public function __construct(string $name, HrefInterface $href, array $attributes = [])
    {
        $this->name = $name;
        $this->href = $href;
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getHref(): HrefInterface
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    public function setHref(HrefInterface $href): void
    {
        $this->href = $href;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}

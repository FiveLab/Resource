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

namespace FiveLab\Component\Resource\Resource\Action;

use FiveLab\Component\Resource\Resource\Href\HrefInterface;

/**
 * The default action of resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Action implements ActionInterface
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
     * @var Method
     */
    private Method $method;

    /**
     * @var array<string, mixed>
     */
    private array $attributes;

    /**
     * Constructor.
     *
     * @param string               $name
     * @param HrefInterface        $href
     * @param Method               $method
     * @param array<string, mixed> $attributes
     */
    public function __construct(string $name, HrefInterface $href, Method $method, array $attributes = [])
    {
        $this->name = $name;
        $this->href = $href;
        $this->method = $method;
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
    public function getMethod(): Method
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod(Method $method): void
    {
        $this->method = $method;
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

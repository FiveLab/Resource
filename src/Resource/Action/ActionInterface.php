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
 * All resource actions should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ActionInterface
{
    /**
     * Get the name of action
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the href of action
     *
     * @return HrefInterface
     */
    public function getHref(): HrefInterface;

    /**
     * Set the href of action
     *
     * @param HrefInterface $href
     */
    public function setHref(HrefInterface $href): void;

    /**
     * Get the method of action
     *
     * @return Method
     */
    public function getMethod(): Method;

    /**
     * Set the method of action
     *
     * @param Method $method
     */
    public function setMethod(Method $method): void;

    /**
     * Get the attributes of action
     *
     * @return array<string, mixed>
     */
    public function getAttributes(): array;

    /**
     * Set the attributes of action
     *
     * @param array<string, mixed> $attributes
     */
    public function setAttributes(array $attributes): void;
}

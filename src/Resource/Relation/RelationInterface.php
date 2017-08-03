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
 * All resource relations should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface RelationInterface
{
    /**
     * Get the name of relation
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the href of this relation
     *
     * @return HrefInterface
     */
    public function getHref(): HrefInterface;

    /**
     * Set new href to relation
     *
     * @param HrefInterface $href
     */
    public function setHref(HrefInterface $href): void;

    /**
     * Get the custom attributes of relation
     *
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Set new custom attributes of relation
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void;
}

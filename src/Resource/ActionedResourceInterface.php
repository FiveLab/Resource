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

namespace FiveLab\Component\Resource\Resource;

use FiveLab\Component\Resource\Resource\Action\ActionCollection;
use FiveLab\Component\Resource\Resource\Action\ActionInterface;

/**
 * The resources which exist actions should implement this interface.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ActionedResourceInterface extends ResourceInterface
{
    /**
     * Add action to resource
     *
     * @param ActionInterface $action
     */
    public function addAction(ActionInterface $action): void;

    /**
     * Get all actions
     *
     * @return ActionCollection|ActionInterface[]
     */
    public function getActions(): ActionCollection;

    /**
     * Remove action
     *
     * @param ActionInterface $action
     */
    public function removeAction(ActionInterface $action): void;
}

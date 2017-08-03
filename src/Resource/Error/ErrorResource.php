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

namespace FiveLab\Component\Resource\Resource\Error;

use FiveLab\Component\Resource\Resource\AbstractResourceSupport;
use FiveLab\Component\Resource\Resource\Href\HrefInterface;
use FiveLab\Component\Resource\Resource\Relation\Relation;

/**
 * Default error resource.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorResource extends AbstractResourceSupport implements ErrorResourceInterface
{
    /**
     * The identifier of error.
     * Can use for multiple errors for split errors.
     *
     * @var string|int
     */
    private $identifier;

    /**
     * The reason of error.
     *
     * @var string|int
     */
    private $reason;

    /**
     * The custom message of error.
     *
     * @var string
     */
    private $message;

    /**
     * The custom attributes for this error.
     *
     * @var array
     */
    private $attributes;

    /**
     * The path of this error.
     * As an example: the name of invalid form field.
     *
     * @var string
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string     $message
     * @param string|int $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     */
    public function __construct(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ) {
        parent::__construct();

        $this->message = $message;
        $this->reason = $reason;
        $this->path = $path;
        $this->attributes = $attributes;
        $this->identifier = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): ?string
    {
        return $this->path;
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
    public function addHelp(HrefInterface $href): void
    {
        $relation = new Relation('help', $href);

        $this->addRelation($relation);
    }
}

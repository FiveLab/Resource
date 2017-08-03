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

namespace FiveLab\Component\Resource\Presentation;

use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * Presentation factory for easy create presentations.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class PresentationFactory
{
    /**
     * Create the presentation
     *
     * @param int               $statusCode
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function create(int $statusCode, ResourceInterface $resource = null): PresentationInterface
    {
        return new Presentation($statusCode, $resource);
    }

    /**
     * Create the success presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function ok(ResourceInterface $resource): PresentationInterface
    {
        return static::create(200, $resource);
    }

    /**
     * Create the created presentation
     *
     * @param ResourceInterface|null $resource
     *
     * @return PresentationInterface
     */
    public static function created(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(201, $resource);
    }

    /**
     * Create accepted presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function accepted(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(202, $resource);
    }

    /**
     * Create non-authoritative information presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function nonAuthoritativeInformation(ResourceInterface $resource): PresentationInterface
    {
        return static::create(203, $resource);
    }

    /**
     * Create the no content presentation
     *
     * @return PresentationInterface
     */
    public static function noContent(): PresentationInterface
    {
        return static::create(204);
    }

    /**
     * Create the reset content presentation
     *
     * @return PresentationInterface
     */
    public static function resetContent(): PresentationInterface
    {
        return static::create(205);
    }

    /**
     * Create the bad request presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function badRequest(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(400, $resource);
    }

    /**
     * Create unauthorized presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function unauthorized(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(401, $resource);
    }

    /**
     * Create forbidden presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function forbidden(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(403, $resource);
    }

    /**
     * Create not found presentation
     *
     * @param ResourceInterface|null $resource
     *
     * @return PresentationInterface
     */
    public static function notFound(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(404, $resource);
    }

    /**
     * Create conflict presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function conflict(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(409, $resource);
    }

    /**
     * Create gone presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function gone(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(410, $resource);
    }

    /**
     * Create request entity to large presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function requestEntityToLarge(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(413, $resource);
    }

    /**
     * Create unsupported media type presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function unsupportedMediaType(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(415, $resource);
    }

    /**
     * Create internal server error presentation
     *
     * @param ResourceInterface $resource
     *
     * @return PresentationInterface
     */
    public static function internalServerError(ResourceInterface $resource = null): PresentationInterface
    {
        return static::create(500, $resource);
    }
}

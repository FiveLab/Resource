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

namespace FiveLab\Component\Resource\Resource\Error;

use FiveLab\Component\Resource\Presentation\PresentationFactory;
use FiveLab\Component\Resource\Presentation\PresentationInterface;

/**
 * The factory for easy create error presentation.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorPresentationFactory
{
    /**
     * Create default error presentation.
     *
     * @param int         $statusCode
     * @param string      $message
     * @param string|null $reason
     * @param string|null $path
     * @param array       $attributes
     * @param string|int  $identifier
     *
     * @return PresentationInterface
     */
    public static function create(
        int $statusCode,
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::create($statusCode, $error);
    }

    /**
     * Create the bad request error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function badRequest(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::badRequest($error);
    }

    /**
     * Create the unauthorized error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function unauthorized(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::unauthorized($error);
    }

    /**
     * Create the forbidden error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function forbidden(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::forbidden($error);
    }

    /**
     * Create the not found error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function notFound(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::notFound($error);
    }

    /**
     * Create the conflict error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function conflict(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::conflict($error);
    }

    /**
     * Create the gone error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function gone(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::gone($error);
    }

    /**
     * Create the request entity to large error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function requestEntityToLarge(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::requestEntityToLarge($error);
    }

    /**
     * Create the unsupported media type error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function unsupportedMediaType(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::unsupportedMediaType($error);
    }

    /**
     * Create the internal server error presentation.
     *
     * @param string     $message
     * @param string     $reason
     * @param string     $path
     * @param array      $attributes
     * @param string|int $identifier
     *
     * @return PresentationInterface
     */
    public static function internalServerError(
        string $message,
        $reason = null,
        string $path = null,
        array $attributes = [],
        $identifier = null
    ): PresentationInterface {
        $error = new ErrorResource($message, $reason, $path, $attributes, $identifier);

        return PresentationFactory::internalServerError($error);
    }
}

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

/**
 * The value object for store method.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Method
{
    public const POST   = 'POST';
    public const PUT    = 'PUT';
    public const PATCH  = 'PATCH';
    public const DELETE = 'DELETE';
    public const GET    = 'GET';

    /**
     * @var string
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!\in_array($value, self::getPossibleValues(), true)) {
            throw new \InvalidArgumentException(\sprintf(
                'Invalid method "%s". Available methods: "%s".',
                $value,
                \implode('", "', self::getPossibleValues())
            ));
        }

        $this->value = $value;
    }

    /**
     * Create POST method
     *
     * @return Method
     */
    public static function post(): Method
    {
        return new self(self::POST);
    }

    /**
     * Create PUT method
     *
     * @return Method
     */
    public static function put(): Method
    {
        return new self(self::PUT);
    }

    /**
     * Create PATCH method
     *
     * @return Method
     */
    public static function patch(): Method
    {
        return new self(self::PATCH);
    }

    /**
     * Create DELETE method
     *
     * @return Method
     */
    public static function delete(): Method
    {
        return new self(self::DELETE);
    }

    /**
     * Create GET method
     *
     * @return Method
     */
    public static function get(): Method
    {
        return new self(self::GET);
    }

    /**
     * Get the value of method
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get the possible values of action method
     *
     * @return array
     */
    public static function getPossibleValues(): array
    {
        return [
            self::POST,
            self::PUT,
            self::PATCH,
            self::DELETE,
            self::GET,
        ];
    }
}

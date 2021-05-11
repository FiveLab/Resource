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

namespace FiveLab\Component\Resource\Tests\Resources;

use FiveLab\Component\Resource\Resource\ResourceInterface;

/**
 * A test address resource
 */
class AddressResource implements ResourceInterface
{
    public string $country;
    public ?string $city;

    public function __construct(string $country, string $city = null)
    {
        $this->country = $country;
        $this->city = $city;
    }
}

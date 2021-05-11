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

use FiveLab\Component\Resource\Resource\AbstractResourceSupport;

/**
 * A test customer resource.
 */
class CustomerResource extends AbstractResourceSupport
{
    public int $id;
    public string $name;
    public AddressResource $address;

    public function __construct(int $id, string $name, AddressResource $address)
    {
        parent::__construct();

        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }
}

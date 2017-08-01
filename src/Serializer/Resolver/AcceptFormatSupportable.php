<?php

/*
 * This file is part of the FiveLab Resource package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\Resource\Serializer\Resolver;

/**
 * Simple supportable for accept via format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AcceptFormatSupportable implements ResourceSerializerSupportableInterface
{
    /**
     * @var string
     */
    private $acceptedMediaTypes;

    /**
     * Constructor.
     *
     * @param array $acceptedMediaTypes
     */
    public function __construct(array $acceptedMediaTypes)
    {
        $this->acceptedMediaTypes = $acceptedMediaTypes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $mediaType): bool
    {
        return in_array($mediaType, $this->acceptedMediaTypes, true);
    }
}

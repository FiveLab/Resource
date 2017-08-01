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

namespace FiveLab\Component\Resource\Serializer\Resolver;

/**
 * Simple supportable for accept via format.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class AcceptFormatSupportable implements ResourceSerializerSupportableInterface
{
    /**
     * @var array
     */
    private $acceptedMediaTypes;

    /**
     * @var array
     */
    private $notSupportedClasses;

    /**
     * Constructor.
     *
     * @param array $acceptedMediaTypes
     * @param array $notSupportedClasses
     */
    public function __construct(array $acceptedMediaTypes, array $notSupportedClasses = [])
    {
        $this->acceptedMediaTypes = $acceptedMediaTypes;
        $this->notSupportedClasses = $notSupportedClasses;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $resourceClass, string $mediaType): bool
    {
        if (!in_array($mediaType, $this->acceptedMediaTypes, true)) {
            return false;
        }

        foreach ($this->notSupportedClasses as $notSupportedClass) {
            if (is_a($resourceClass, $notSupportedClass, true)) {
                return false;
            }
        }

        return true;
    }
}

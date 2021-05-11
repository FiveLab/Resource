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

namespace FiveLab\Component\Resource\Serializer\Resolver;

use FiveLab\Component\Resource\Serializer\ResourceSerializerInterface;

/**
 * Default resolver for resolve serializer by media types.
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ResourceSerializerResolver implements ResourceSerializerResolverInterface
{
    /**
     * @var array<int, array>
     */
    private array $map = [];

    /**
     * Add the resource normalizer to registry
     *
     * @param ResourceSerializerSupportableInterface $supportable
     * @param ResourceSerializerInterface            $serializer
     */
    public function add(ResourceSerializerSupportableInterface $supportable, ResourceSerializerInterface $serializer): void
    {
        $this->map[] = [$supportable, $serializer];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveByMediaType(string $resourceClass, string $mediaType): ResourceSerializerInterface
    {
        /** @var ResourceSerializerSupportableInterface $supportable */
        foreach ($this->map as [$supportable, $serializer]) {
            if ($supportable->supports($resourceClass, $mediaType)) {
                return $serializer;
            }
        }

        throw new ResourceSerializerNotFoundException(\sprintf(
            'Not found serializer for resource for media type "%s".',
            $mediaType
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function resolveByMediaTypes(string $resourceClass, array $mediaTypes, &$acceptMediaType): ResourceSerializerInterface
    {
        $serializer = null;

        foreach ($mediaTypes as $mediaType) {
            try {
                $serializer = $this->resolveByMediaType($resourceClass, $mediaType);
                $acceptMediaType = $mediaType;

                break;
            } catch (ResourceSerializerNotFoundException $e) {
                // The media type not supported.
            }
        }

        if (!$serializer) {
            throw new ResourceSerializerNotFoundException(\sprintf(
                'Can\'t resolve resource serializer for any media types: "%s".',
                \implode('", "', $mediaTypes)
            ));
        }

        return $serializer;
    }
}

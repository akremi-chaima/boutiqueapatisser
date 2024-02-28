<?php

namespace App\Serializer\Collection;

use App\Entity\Collection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CollectionNormalizer implements NormalizerInterface
{
    /**
     * @param Collection $collection
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($collection, string $format = null, array $context = [])
    {
        return [
            'id' => $collection->getId(),
            'name' => $collection->getName(),
            'isActive' => $collection->isActive()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Collection;
    }

}

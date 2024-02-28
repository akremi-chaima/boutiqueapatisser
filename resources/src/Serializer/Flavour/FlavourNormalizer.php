<?php

namespace App\Serializer\Flavour;

use App\Entity\Flavour;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FlavourNormalizer implements NormalizerInterface
{
    /**
     * @param Flavour $flavour
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($flavour, string $format = null, array $context = [])
    {
        return [
            'id' => $flavour->getId(),
            'name' => $flavour->getName(),
            'isActive' => $flavour->isActive()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Flavour;
    }
}
<?php

namespace App\Serializer\Address;

use App\Entity\Address;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AddressNormalizer implements NormalizerInterface
{
    /**
     * @param Address $address
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($address, string $format = null, array $context = [])
    {
        return [
            'id' => $address->getId(),
            'city' => $address->getCity(),
            'zipCode' => $address->getZipCode(),
            'street' => $address->getStreet()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Address;
    }

}
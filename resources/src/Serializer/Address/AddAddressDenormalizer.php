<?php

namespace App\Serializer\Address;

use App\DTO\Address\AddAddressDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddAddressDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddAddressDTO())
            ->setCity($data['city'] ?? null)
            ->setZipCode($data['zipCode'] ?? null)
            ->setStreet($data['street'] ?? null)
            ->setUserId($data['userId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddAddressDTO::class;
    }
}
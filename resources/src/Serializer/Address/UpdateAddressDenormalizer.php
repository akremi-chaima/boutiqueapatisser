<?php

namespace App\Serializer\Address;

use App\DTO\Address\UpdateAddressDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateAddressDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateAddressDTO())
            ->setId($data['id'] ?? null)
            ->setCity($data['city'] ?? null)
            ->setZipCode($data['zipCode'] ?? null)
            ->setStreet($data['street'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateAddressDTO::class;
    }
}
<?php

namespace App\Serializer\User;

use App\DTO\User\UpdateUserDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateUserDenormalizer implements DenormalizerInterface
{

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateUserDTO())
            ->setFirstName($data['firstName'] ?? null)
            ->setLastName($data['lastName'] ?? null)
            ->setEmail($data['email'] ?? null)
            ->setPhoneNumber($data['phoneNumber'] ?? null)
            ->setCity($data['city'] ?? null)
            ->setZipCode($data['zipCode'] ?? null)
            ->setStreet($data['street'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateUserDTO::class;
    }
}
<?php

namespace App\Serializer\User;

use App\DTO\User\AddUserDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddUserDenormalizer implements DenormalizerInterface
{

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddUserDTO())
            ->setFirstName($data['firstName'] ?? null)
            ->setLastName($data['lastName'] ?? null)
            ->setPassword($data['password'] ?? null)
            ->setEmail($data['email'] ?? null)
            ->setRoleId($data['roleId']);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddUserDTO::class;
    }
}
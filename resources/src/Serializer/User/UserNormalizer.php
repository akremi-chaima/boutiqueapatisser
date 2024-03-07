<?php

namespace App\Serializer\User;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /**
     * @param User $user
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($user, string $format = null, array $context = [])
    {
        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'phoneNumber' => $user->getPhoneNumber(),
            'role' => $user->getRoles()[0]
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User;
    }
}
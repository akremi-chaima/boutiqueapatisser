<?php

namespace App\Serializer\User;

use App\Entity\User;
use App\Serializer\Role\RoleNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /** @var RoleNormalizer */
    private $roleNormalizer;

    public function __construct(RoleNormalizer $roleNormalizer) {
        $this->roleNormalizer = $roleNormalizer;
    }
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
            'role' => $this->roleNormalizer->normalize($user->getRole())
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User;
    }
}
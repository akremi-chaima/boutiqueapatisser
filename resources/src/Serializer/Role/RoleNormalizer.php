<?php

namespace App\Serializer\Role;

use App\Entity\Role;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RoleNormalizer implements NormalizerInterface
{
    /**
     * @param Role $role
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($role, string $format = null, array $context = [])
    {
        return [
            'id' => $role->getId(),
            'name' => $role->getName(),
            'code' => $role->getCode()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Role;
    }
}
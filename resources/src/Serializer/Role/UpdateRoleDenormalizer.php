<?php

namespace App\Serializer\Role;

use App\DTO\Role\UpdateRoleDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateRoleDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateRoleDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setCode($data['code'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateRoleDTO::class;
    }
}
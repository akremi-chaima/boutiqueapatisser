<?php

namespace App\Serializer\Flavour;

use App\DTO\Flavour\UpdateFlavourDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateFlavourDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateFlavourDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateFlavourDTO::class;
    }
}
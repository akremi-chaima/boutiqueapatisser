<?php

namespace App\Serializer\Flavour;

use App\DTO\Flavour\AddFlavourDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddFlavourDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddFlavourDTO())
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddFlavourDTO::class;
    }
}
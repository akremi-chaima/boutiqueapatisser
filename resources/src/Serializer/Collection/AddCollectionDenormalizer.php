<?php

namespace App\Serializer\Collection;

use App\DTO\Collection\AddCollectionDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddCollectionDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddCollectionDTO())
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddCollectionDTO::class;
    }
}
<?php

namespace App\Serializer\Collection;

use App\DTO\Collection\UpdateCollectionDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateCollectionDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateCollectionDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateCollectionDTO::class;
    }
}
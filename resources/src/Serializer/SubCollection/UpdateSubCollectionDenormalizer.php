<?php

namespace App\Serializer\SubCollection;

use App\DTO\SubCollection\UpdateSubCollectionDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateSubCollectionDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateSubCollectionDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null)
            ->setCollectionId($data['collectionId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateSubCollectionDTO::class;
    }
}
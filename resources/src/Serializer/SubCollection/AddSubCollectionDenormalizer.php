<?php

namespace App\Serializer\SubCollection;

use App\DTO\SubCollection\AddSubCollectionDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddSubCollectionDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddSubCollectionDTO())
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null)
            ->setCollectionId($data['collectionId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddSubCollectionDTO::class;
    }
}
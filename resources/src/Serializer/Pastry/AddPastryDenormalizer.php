<?php

namespace App\Serializer\Pastry;

use App\DTO\Pastry\AddPastryDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddPastryDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddPastryDTO())
            ->setName($data['name'] ?? null)
            ->setPrice($data['price'] ?? null)
            ->setDescription($data['description'] ?? null)
            ->setIsVisible($data['isVisible'] ?? null)
            ->setCategoryId($data['categoryId'] ?? null)
            ->setSubCollectionId($data['subCollectionId'] ?? null)
            ->setFlavourId($data['flavourId'] ?? null)
            ->setFormats($data['formats'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddPastryDTO::class;
    }
}
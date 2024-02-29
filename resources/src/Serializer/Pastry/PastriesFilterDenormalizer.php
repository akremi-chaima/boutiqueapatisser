<?php

namespace App\Serializer\Pastry;

use App\DTO\Pastry\PastriesFilterDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PastriesFilterDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new PastriesFilterDTO())
            ->setName($data['name'] ?? null)
            ->setPrice($data['price'] ?? null)
            ->setCategoryId($data['categoryId'] ?? null)
            ->setSubCollectionId($data['subCollectionId'] ?? null)
            ->setFlavourId($data['flavourId'] ?? null)
            ->setOrderBy($data['orderBy'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === PastriesFilterDTO::class;
    }
}
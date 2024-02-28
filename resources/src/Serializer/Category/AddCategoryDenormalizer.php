<?php

namespace App\Serializer\Category;

use App\DTO\Category\AddCategoryDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddCategoryDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddCategoryDTO())
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddCategoryDTO::class;
    }
}
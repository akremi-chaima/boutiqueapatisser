<?php

namespace App\Serializer\Category;

use App\DTO\Category\UpdateCategoryDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateCategoryDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateCategoryDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setIsActive($data['isActive'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateCategoryDTO::class;
    }
}
<?php

namespace App\Serializer\Category;

use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategoryNormalizer implements NormalizerInterface
{
    /**
     * @param Category $category
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($category, string $format = null, array $context = [])
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'isActive' => $category->isActive()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Category;
    }

}
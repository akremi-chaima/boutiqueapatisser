<?php

namespace App\Serializer\Picture;

use App\Entity\Picture;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PictureNormalizer implements NormalizerInterface
{
    /**
     * @param Picture $picture
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($picture, string $format = null, array $context = [])
    {
        return [
            'id' => $picture->getId(),
            'url' => '/uploads/' . $picture->getPastry()->getId() . '/' . $picture->getId() . '/' . $picture->getName(),
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Picture;
    }

}
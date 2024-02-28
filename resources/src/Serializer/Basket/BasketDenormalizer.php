<?php

namespace App\Serializer\Basket;

use App\DTO\Basket\BasketDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BasketDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new BasketDTO())
            ->setPastries($data['pastries'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === BasketDTO::class;
    }
}
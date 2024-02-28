<?php

namespace App\Serializer\BasketContent;

use App\DTO\BasketContent\BasketContentDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BasketContentDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new BasketContentDTO())
            ->setQuantity($data['quantity'] ?? null)
            ->setPastryId($data['pastryId'] ?? null)
            ->setFormatId($data['formatId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === BasketContentDTO::class;
    }
}
<?php

namespace App\Serializer\Order;

use App\DTO\Order\OrderContentDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderContentDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new OrderContentDTO())
            ->setQuantity($data['quantity'] ?? null)
            ->setPastryId($data['pastryId'] ?? null)
            ->setFormatId($data['formatId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === OrderContentDTO::class;
    }
}
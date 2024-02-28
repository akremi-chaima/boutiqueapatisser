<?php

namespace App\Serializer\OrderPastries;

use App\DTO\OrderPastries\AddOrderPastriesDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddOrderPastriesDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddOrderPastriesDTO())
            ->setQuantity($data['quantity'] ?? null)
            ->setPastryId($data['pastryId'] ?? null)
            ->setOrderId($data['orderId'] ?? null)
            ->setFormatId($data['formatId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddOrderPastriesDTO::class;
    }
}
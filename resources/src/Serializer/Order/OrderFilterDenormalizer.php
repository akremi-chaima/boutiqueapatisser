<?php

namespace App\Serializer\Order;

use App\DTO\Order\OrderFilterDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderFilterDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new OrderFilterDTO())
            ->setStatusId($data['statusId'] ?? null)
            ->setUserName($data['userName'] ?? null)
            ->setDate($data['date'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === OrderFilterDTO::class;
    }
}
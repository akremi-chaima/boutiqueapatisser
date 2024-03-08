<?php

namespace App\Serializer\Order;

use App\DTO\Order\OrderDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new OrderDTO())
            ->setPastries($data['pastries'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === OrderDTO::class;
    }
}
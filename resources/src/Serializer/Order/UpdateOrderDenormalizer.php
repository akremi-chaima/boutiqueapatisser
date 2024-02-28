<?php

namespace App\Serializer\Order;

use App\DTO\Order\UpdateOrderDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateOrderDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateOrderDTO())
            ->setId($data['id'] ?? null)
            ->setUserId($data['userId'] ?? null)
            ->setOrderStatausId($data['orderStatusId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateOrderDTO::class;
    }
}
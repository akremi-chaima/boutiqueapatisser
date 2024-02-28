<?php

namespace App\Serializer\OrderStatus;

use App\DTO\OrderStatus\UpdateOrderStatusDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateOrderStatusDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateOrderStatusDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateOrderStatusDTO::class;
    }
}
<?php

namespace App\Serializer\OrderStatus;

use App\DTO\OrderStatus\AddOrderStatusDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddOrderStatusDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddOrderStatusDTO())
            ->setName($data['name'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddOrderStatusDTO::class;
    }
}
<?php

namespace App\Serializer\Order;

use App\DTO\Order\AddOrderDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddOrderDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddOrderDTO())
            ->setPastries($data['pastries'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddOrderDTO::class;
    }
}
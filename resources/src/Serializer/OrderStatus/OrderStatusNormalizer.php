<?php

namespace App\Serializer\OrderStatus;

use App\Entity\OrderStatus;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderStatusNormalizer implements NormalizerInterface
{
    /**
     * @param OrderStatus $orderStatus
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($orderStatus, string $format = null, array $context = [])
    {
        return [
            'id' => $orderStatus->getId(),
            'name' => $orderStatus->getName(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof OrderStatus;
    }
}
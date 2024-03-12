<?php
namespace App\Serializer\Order;

use App\Entity\OrderStatus;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class StatusNormalizer  implements NormalizerInterface
{
    /**
     * @param OrderStatus $status
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($status, string $format = null, array $context = [])
    {
        return [
            'id' => $status->getId(),
            'name' => $status->getName(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof OrderStatus;
    }

}


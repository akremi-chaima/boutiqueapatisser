<?php

namespace App\Serializer\OrderPastries;

use App\Entity\OrderPastries;
use App\Serializer\Order\OrderNormalizer;
use App\Serializer\Pastry\PastryNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderPastriesNormalizer implements NormalizerInterface
{

    /** @var PastryNormalizer $pastryNormalizer */
    private $pastryNormalizer;

    /** @var OrderNormalizer $orderNormalizer */
    private $orderNormalizer;

    /**
     * @param PastryNormalizer $pastryNormalizer
     * @param OrderNormalizer $orderNormalizer
     */

    public function __construct(
        PastryNormalizer $pastryNormalizer,
        OrderNormalizer $orderNormalizer

    )
    {
        $this->pastryNormalizer = $pastryNormalizer;
        $this->orderNormalizer = $orderNormalizer;
    }
    /**
     * @param OrderPastries $orderPastries
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($orderPastries, string $format = null, array $context = [])
    {
        return [
            'quantity' => $orderPastries->getQuantity(),
            'pastryId' => $this->pastryNormalizer->normalize($orderPastries->getPastry()),
            'orderId' => $this->orderNormalizer->normalize($orderPastries->getOrder()),
            'formats' => null

        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof OrderPastries;
    }

}


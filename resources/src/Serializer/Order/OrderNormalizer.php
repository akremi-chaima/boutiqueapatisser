<?php

namespace App\Serializer\Order;

use App\Entity\Order;
use App\Serializer\OrderStatus\OrderStatusNormalizer;
use App\Serializer\User\UserNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderNormalizer implements NormalizerInterface
{

    /** @var UserNormalizer $userNormalizer */
    private $userNormalizer;

    /** @var OrderStatusNormalizer $orderStatusNormalizer*/
    private $orderStatusNormalizer;


    public function __construct(
        UserNormalizer $userNormalizer,
        OrderStatusNormalizer $orderStatusNormalizer
    )
    {
        $this->userNormalizer = $userNormalizer;
        $this->orderStatusNormalizer = $orderStatusNormalizer;
    }
    /**
     * @param Order $order
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($order, string $format = null, array $context = [])
    {
        return [
            'id' => $order->getId(),
            'created_at' => $order->getCreatedAt()->format('d/m/Y'),
            'userId' => $this->userNormalizer->normalize($order->getUser()),
            'orderStatusId' =>$this->orderStatusNormalizer->normalize($order->getOrderStatus())

        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Order;
    }

}


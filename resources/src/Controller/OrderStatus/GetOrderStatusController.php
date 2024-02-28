<?php

namespace App\Controller\OrderStatus;

use App\Manager\FlavourManager;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetOrderStatusController extends AbstractController
{
    /** @var OrderStatusManager  */
    private $orderStatusManager;

    /** @var SerializerInterface */
    private $serializer;


    /**
     * @param OrderStatusManager $orderStatusManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        OrderStatusManager $orderStatusManager,
        SerializerInterface $serializer
    )
    {
        $this->orderStatusManager = $orderStatusManager;
        $this->serializer = $serializer;
    }

    /**
     * Get order status list
     *
     * @Route("/api/order/status", methods={"GET"})
     *
     * @OA\Tag(name="OrderStatus")
     *
     * @OA\Response(response=200, description="Flavours list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $orderStatus = $this->orderStatusManager->findAll();
        $normalizedList = $this->serializer->serialize($orderStatus, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
<?php

namespace App\Controller\Order;

use App\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetOrdersController extends AbstractController
{
    /* @var OrderManager */
    private $orderManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param OrderManager $orderManager
     * @param SerializerInterface $serializer
     */
    public function __construct(OrderManager $orderManager, SerializerInterface $serializer)
    {
        $this->orderManager = $orderManager;
        $this->serializer = $serializer;
    }

    /**
     * Get orders list
     *
     * @Route("/api/orders", methods={"GET"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\Response(response=200, description="Orders list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $orders = $this->orderManager->findAll();
        $normalizedList = $this->serializer->serialize($orders, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
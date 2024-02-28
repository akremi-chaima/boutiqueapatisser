<?php

namespace App\Controller\Order;

use App\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetOrderController extends AbstractController
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
     * Get order bu id
     *
     * @Route("/api/order/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\Response(response=200, description="Order")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $order = $this->orderManager->findOneBy(['id' =>$id]);
        if (is_null($order)) {
        return new JsonResponse(['error_message' => 'The order is not found'], Response::HTTP_BAD_REQUEST);
    }
        return new JsonResponse(json_decode($this->serializer->serialize($order, 'json'), true), Response::HTTP_OK);

    }

}
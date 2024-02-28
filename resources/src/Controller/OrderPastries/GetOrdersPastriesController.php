<?php

namespace App\Controller\OrderPastries;

use App\Manager\OrderPastriesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetOrdersPastriesController extends AbstractController
{
    /* @var OrderPastriesManager */
    private $orderPastriesManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param OrderPastriesManager $orderPastriesManager
     * @param SerializerInterface $serializer
     */
    public function __construct(OrderPastriesManager $orderPastriesManager, SerializerInterface $serializer)
    {
        $this->orderPastriesManager = $orderPastriesManager;
        $this->serializer = $serializer;
    }

    /**
     * Get orders pastries list
     *
     * @Route("/api/orders/pastries", methods={"GET"})
     *
     * @OA\Tag(name="OrderPastries")
     *
     * @OA\Response(response=200, description="Orders pastries list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $ordersPastries = $this->orderPastriesManager->findAll();
        $normalizedList = $this->serializer->serialize($ordersPastries, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
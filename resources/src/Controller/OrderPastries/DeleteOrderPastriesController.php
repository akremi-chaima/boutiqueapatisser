<?php

namespace App\Controller\OrderPastries;

use App\Entity\OrderPastries;
use App\Manager\FlavourManager;
use App\Manager\OrderPastriesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class DeleteOrderPastriesController extends AbstractController
{
    /** @var OrderPastriesManager  */
    private $orderPastriesManager;

    /**
     * @param OrderPastriesManager $orderPastriesManager
     */
    public function __construct(OrderPastriesManager $orderPastriesManager)
    {
        $this->orderPastriesManager = $orderPastriesManager;
    }

    /**
     * Delete order Pastries
     *
     * @Route("/api/delete/order/pastries/{orderId}", methods={"PUT"})
     *
     * @OA\Tag(name="OrderPastries")
     *
     * @OA\Response(response=200, description="Order pastries deleted")
     *
     * @param int $orderId
     * @return JsonResponse
     */
    public function __invoke(int $orderId): JsonResponse
    {
        /** @var OrderPastries[] $orderPastries */
        $orderPastries = $this->orderPastriesManager->findBy(['order' => $orderId]);
        if (empty($orderPastries)) {
            return new JsonResponse(['error_message' => 'The order is not found'], Response::HTTP_BAD_REQUEST);
        }
        foreach ($orderPastries as $orderPastry) {
            $this->orderPastriesManager->delete($orderPastry);
        }

        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
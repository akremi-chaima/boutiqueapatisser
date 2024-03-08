<?php

namespace App\Controller\Order;

use App\Entity\Role;
use App\Manager\OrderManager;
use App\Manager\OrderPastriesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetCustomerOrdersController extends AbstractController
{
    /* @var OrderManager */
    private $orderManager;

    /* @var OrderPastriesManager */
    private $orderPastriesManager;

    /**
     * @param OrderManager $orderManager
     * @param OrderPastriesManager $orderPastriesManager
     */
    public function __construct(OrderManager $orderManager, OrderPastriesManager $orderPastriesManager)
    {
        $this->orderManager = $orderManager;
        $this->orderPastriesManager = $orderPastriesManager;
    }

    /**
     * Get customer orders list
     *
     * @Route("/api/private/customer/orders", methods={"GET"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\Response(response=200, description="Customer orders list")
     *
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function __invoke(UserInterface $user): JsonResponse
    {
        if ($user->getRoles()[0] !== Role::ROLE_CUSTOMER) {
            return new JsonResponse(['error_message' => 'The user should be customer'], Response::HTTP_BAD_REQUEST);
        }
        $result = [];
        $orders = $this->orderManager->get(null, $user->getId());
        foreach ($orders as $order) {
            $result[] = array_merge($order, ['content' => $this->orderPastriesManager->get($order['id'])]);
        }

        return new JsonResponse($result, Response::HTTP_OK);
    }

}
<?php

namespace App\Controller\Order;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\Role;
use App\Manager\OrderManager;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class UpdateOrderStatusController extends AbstractController
{
    /* @var OrderManager */
    private $orderManager;

    /* @var OrderStatusManager */
    private $orderStatusManager;

    /**
     * @param OrderManager $orderManager
     * @param OrderStatusManager $orderStatusManager
     */
    public function __construct(
        OrderManager $orderManager,
        OrderStatusManager $orderStatusManager
    ) {
        $this->orderManager = $orderManager;
        $this->orderStatusManager = $orderStatusManager;
    }

    /**
     * Update order status
     *
     * @Route("/api/private/customer/order/{id}/{statusId}", methods={"PUT"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\Response(response=200, description="Update order status")
     * @OA\Response(response=400, description="The user should be administrator | Order was not found | Status was not found")
     *
     * @param UserInterface $user
     * @param int $id
     * @param int $statusId
     * @return JsonResponse
     */
    public function __invoke(UserInterface $user, int $id, int $statusId): JsonResponse
    {
        if ($user->getRoles()[0] !== Role::ROLE_ADMINISTRATOR) {
            return new JsonResponse(['error_message' => 'The user should be administrator'], Response::HTTP_BAD_REQUEST);
        }

        /** @var Order|null $order */
        $order = $this->orderManager->findOneBy(['id' => $id]);
        if (empty($order)) {
            return new JsonResponse(['error_message' => 'Order was not found'], Response::HTTP_BAD_REQUEST);
        }

        /** @var OrderStatus|null $status */
        $status = $this->orderStatusManager->findOneBy(['id' => $statusId]);
        if (empty($status)) {
            return new JsonResponse(['error_message' => 'Status was not found'], Response::HTTP_BAD_REQUEST);
        }

        $order->setOrderStatus($status);
        $this->orderManager->save($order);

        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }
}
<?php

namespace App\Controller\OrderStatus;

use App\Entity\Role;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @Route("/api/private/order/status", methods={"GET"})
     *
     * @OA\Tag(name="OrderStatus")
     *
     * @OA\Response(response=200, description="Order status list")
     * @OA\Response(response=400, description="Invalid user role")
     *
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function __invoke(UserInterface $user): JsonResponse
    {
        if ($user->getRoles()[0] != Role::ROLE_ADMINISTRATOR) {
            return new JsonResponse(['error_messages' => 'invalid_user_role'], Response::HTTP_BAD_REQUEST);
        }
        $orderStatus = $this->orderStatusManager->findAll();
        $normalizedList = $this->serializer->serialize($orderStatus, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
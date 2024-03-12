<?php

namespace App\Controller\Order;

use App\Entity\Role;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;

class GetStatusController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /* @var OrderStatusManager $orderStatusManager */
    private $orderStatusManager;

    /**
     * @param OrderStatusManager $orderStatusManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        OrderStatusManager $orderStatusManager,
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
        $this->orderStatusManager = $orderStatusManager;
    }

    /**
     * Get status list
     *
     * @Route("/api/private/status", methods={"GET"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\Response(response=200, description="All status list")
     * @OA\Response(response=400, description="Invalid data | The user should be administrator")
     *
     * @param UserInterface $user
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, UserInterface $user): JsonResponse
    {
        if ($user->getRoles()[0] !== Role::ROLE_ADMINISTRATOR) {
            return new JsonResponse(['error_message' => 'The user should be administrator'], Response::HTTP_BAD_REQUEST);
        }

        $status = $this->orderStatusManager->findAll();
        $normalizedList = $this->serializer->serialize($status, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
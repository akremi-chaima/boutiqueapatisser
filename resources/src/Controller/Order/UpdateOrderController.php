<?php

namespace App\Controller\Order;

use App\DTO\Order\UpdateOrderDTO;
use App\Manager\OrderManager;
use App\Manager\OrderStatusManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateOrderController extends AbstractController
{
    /* @var UserManager */
    private $userManager;

    /* @var OrderStatusManager */
    private $orderStatusManager;

    /** @var OrderManager */
    private $orderManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param UserManager $userManager
     * @param OrderStatusManager $orderStatusManager
     * @param OrderManager $orderManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserManager $userManager,
        OrderStatusManager $orderStatusManager,
        OrderManager $orderManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->userManager = $userManager;
        $this->orderStatusManager = $orderStatusManager;
        $this->orderManager = $orderManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update Order
     *
     * @Route("/api/update/order", methods={"PUT"})
     *
     * @OA\Tag(name="Orders")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "userId", "orderStatusId"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="userId", type="intger"),
     *              @OA\Property(property="orderStatusId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Order updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateOrderDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateOrderDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userManager->findOneBy(['id' => $dto->getUserId()]);
        if (is_null($user)) {
            return new JsonResponse(['error_message' => 'The user is not found'], Response::HTTP_BAD_REQUEST);
        }

        $orderStatus = $this->orderStatusManager->findOneBy(['id' => $dto->getOrderStatausId()]);
        if (is_null($orderStatus)) {
            return new JsonResponse(['error_message' => 'The order status is not found'], Response::HTTP_BAD_REQUEST);
        }

        $order= $this->orderManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($order)) {
            return new JsonResponse(['error_message' => 'The order is not found'], Response::HTTP_BAD_REQUEST);
        }

        $order->setOrderStatus($orderStatus)
            ->setUser($user);

        $this->orderManager->save($order);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
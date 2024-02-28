<?php

namespace App\Controller\OrderStatus;

use App\DTO\Flavour\UpdateFlavourDTO;
use App\DTO\OrderStatus\UpdateOrderStatusDTO;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateOrderStatusController extends AbstractController
{
    /** @var OrderStatusManager  */
    private $orderStatusManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param OrderStatusManager $orderStatusManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        OrderStatusManager $orderStatusManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->orderStatusManager = $orderStatusManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update order status
     *
     * @Route("/api/update/order/status", methods={"PUT"})
     *
     * @OA\Tag(name="OrderStatus")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Order status updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateOrderStatusDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateOrderStatusDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $orderStatus = $this->orderStatusManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($orderStatus)) {
            return new JsonResponse(['error_message' => 'The order status is not found'], Response::HTTP_BAD_REQUEST);
        }

        $orderStatus->setName($dto->getName());

        $this->orderStatusManager->save($orderStatus);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
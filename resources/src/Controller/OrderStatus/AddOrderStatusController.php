<?php

namespace App\Controller\OrderStatus;

use App\DTO\Flavour\UpdateFlavourDTO;
use App\DTO\OrderStatus\AddOrderStatusDTO;
use App\DTO\OrderStatus\UpdateOrderStatusDTO;
use App\Entity\OrderStatus;
use App\Manager\OrderStatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddOrderStatusController extends AbstractController
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
     * @Route("/api/add/order/status", methods={"POST"})
     *
     * @OA\Tag(name="OrderStatus")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"name"},
     *              @OA\Property(property="name", type="string"),
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Order status added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var AddOrderStatusDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddOrderStatusDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }



        $orderStatus = (new OrderStatus())
            ->setName($dto->getName());

        $this->orderStatusManager->save($orderStatus);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
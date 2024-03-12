<?php

namespace App\Controller\Order;

use App\DTO\Order\OrderFilterDTO;
use App\Entity\Role;
use App\Manager\OrderManager;
use App\Manager\OrderPastriesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetOrdersController extends AbstractController
{
    /* @var OrderManager */
    private $orderManager;

    /** @var SerializerInterface */
    private $serializer;

    /* @var OrderPastriesManager */
    private $orderPastriesManager;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param OrderManager $orderManager
     * @param OrderPastriesManager $orderPastriesManager
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        OrderManager $orderManager,
        OrderPastriesManager $orderPastriesManager,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->orderManager = $orderManager;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->orderPastriesManager = $orderPastriesManager;
    }

    /**
     * Get orders list
     *
     * @Route("/api/private/orders", methods={"POST"})
     *
     * @OA\Tag(name="Orders")
     *
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(property="userName", type="string"),
     *              @OA\Property(property="date", type="string"),
     *              @OA\Property(property="statusId", type="integer")
     *          )
     *      )
     * )
     * @OA\Response(response=200, description="All orders list")
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

        /** @var OrderFilterDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), OrderFilterDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $result = [];
        $orders = $this->orderManager->get($dto);
        foreach ($orders as $order) {
            $order['createdAt'] = $order['createdAt']->format('d/m/Y H:i');
            $result[] = array_merge($order, ['content' => $this->orderPastriesManager->get($order['id'])]);
        }

        return new JsonResponse($result, Response::HTTP_OK);
    }

}
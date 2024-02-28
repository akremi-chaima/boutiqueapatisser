<?php

namespace App\Controller\Order;

use App\DTO\Basket\BasketDTO;
use App\DTO\BasketContent\BasketContentDTO;
use App\Entity\Order;
use App\Entity\OrderPastries;
use App\Manager\FormatManager;
use App\Manager\OrderManager;
use App\Manager\OrderPastriesManager;
use App\Manager\OrderStatusManager;
use App\Manager\PastryManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddBasketController extends AbstractController
{
    /* @var UserManager */
    private $userManager;

    /* @var OrderStatusManager */
    private $orderStatusManager;

    /** @var OrderPastriesManager */
    private $orderPastriesManager;

    /** @var OrderManager */
    private $orderManager;

    /* @var PastryManager */
    private $pastryManager;

    /** @var FormatManager */
    private $formatManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param UserManager $userManager
     * @param OrderStatusManager $orderStatusManager
     * @param OrderPastriesManager $orderPastriesManager
     * @param OrderManager $orderManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserManager $userManager,
        OrderStatusManager $orderStatusManager,
        OrderPastriesManager $orderPastriesManager,
        OrderManager $orderManager,
        PastryManager $pastryManager,
        FormatManager $formatManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->userManager = $userManager;
        $this->orderStatusManager = $orderStatusManager;
        $this->orderPastriesManager = $orderPastriesManager;
        $this->orderManager = $orderManager;
        $this->pastryManager = $pastryManager;
        $this->formatManager = $formatManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Add Order
     *
     * @Route("/api/add/basket/{userId}", methods={"POST"})
     *
     * @OA\Tag(name="Orders")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"quantity", "pastryId"},
     *              @OA\Property(property="quantity", type="intger"),
     *              @OA\Property(property="pastryId", type="intger"),
     *              @OA\Property(property="formatId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Order added")
     *
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $userId): JsonResponse
    {
        /** @var BasketDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), BasketDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        if (empty($dto->getPastries())) {
            return new JsonResponse(['error_message' => 'The basket should not be empty'], Response::HTTP_BAD_REQUEST);
        }

        /** @var OrderPastries[] $orderPastries */
        $orderPastries = [];
        foreach ($dto->getPastries() as $item) {
            /** @var BasketContentDTO  $basketContentDTO */
            $basketContentDTO = $this->serializer->deserialize(json_encode($item), BasketContentDTO::class, 'json');

            $errors = $this->validator->validate($basketContentDTO);

            if ($errors->count()) {
                $display = [];
                foreach ($errors as $error) {
                    $display[$error->getPropertyPath()] = $error->getMessage();
                }
                return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
            }

            $pastry = $this->pastryManager->findOneBy(['id' => $item->getPastryId()]);
            $format= $this->formatManager->findOneBy(['id' => $item->getFormatId()]);
            if (!empty($pastry) && !empty($format)) {
                $orderPastries[] = (new OrderPastries())
                    ->setQuantity($item->getQuantity())
                    ->setPastry($pastry)
                    ->setFormat($format);
            }
        }

        $user = $this->userManager->findOneBy(['id' => $userId]);
        if (is_null($user)) {
            return new JsonResponse(['error_message' => 'The user is not found'], Response::HTTP_BAD_REQUEST);
        }

        $orderStatus = $this->orderStatusManager->findOneBy(['name' => 'en attente de validation']);
        if (is_null($orderStatus)) {
            return new JsonResponse(['error_message' => 'The order status is not found'], Response::HTTP_BAD_REQUEST);
        }

        if (empty($orderPastries)) {
            return new JsonResponse(['error_message' => 'The order pastries should not be empty'], Response::HTTP_BAD_REQUEST);
        }

        $order = (new Order())
            ->setCreatedAt(new \DateTime())
            ->setOrderStatus($orderStatus)
            ->setUser($user);
        $this->orderManager->save($order);

        foreach ($orderPastries as $item) {
            $item->setOrder($order);
            $this->orderPastriesManager->save($item);
        }
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
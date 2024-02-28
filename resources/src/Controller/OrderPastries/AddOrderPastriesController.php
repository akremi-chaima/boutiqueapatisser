<?php

namespace App\Controller\OrderPastries;

use App\DTO\OrderPastries\AddOrderPastriesDTO;
use App\Entity\OrderPastries;
use App\Manager\FormatManager;
use App\Manager\OrderManager;
use App\Manager\OrderPastriesManager;
use App\Manager\PastryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddOrderPastriesController extends AbstractController
{
    /* @var PastryManager */
    private $pastryManager;

    /* @var OrderPastriesManager */
    private $orderPastriesManager;

    /** @var OrderManager */
    private $orderManager;

    /** @var FormatManager */
    private $formatManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;


    public function __construct(
        PastryManager $pastryManager,
        OrderPastriesManager $orderPastriesManager,
        OrderManager $orderManager,
        FormatManager $formatManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->pastryManager = $pastryManager;
        $this->orderPastriesManager = $orderPastriesManager;
        $this->orderManager = $orderManager;
        $this->formatManager = $formatManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Add Order Pastries
     *
     * @Route("/api/add/order/pastries", methods={"POST"})
     *
     * @OA\Tag(name="OrderPastries")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"quantity", "pastryId", "orderId", "formatId"},
     *              @OA\Property(property="quantity", type="integer"),
     *              @OA\Property(property="pastryId", type="intger"),
     *              @OA\Property(property="orderId", type="intger"),
     *              @OA\Property(property="formatId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Order pastries added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateOrderPa $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddOrderPastriesDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $pastry = $this->pastryManager->findOneBy(['id' => $dto->getPastryId()]);
        if (is_null($pastry)) {
            return new JsonResponse(['error_message' => 'The pastry is not found'], Response::HTTP_BAD_REQUEST);
        }

        $order= $this->orderManager->findOneBy(['id' => $dto->getOrderId()]);
        if (is_null($order)) {
            return new JsonResponse(['error_message' => 'The order is not found'], Response::HTTP_BAD_REQUEST);
        }

        $format= $this->formatManager->findOneBy(['id' => $dto->getFormatId()]);
        if (is_null($format)) {
            return new JsonResponse(['error_message' => 'The format is not found'], Response::HTTP_BAD_REQUEST);
        }

        $orderPastries = (new OrderPastries())
            ->setQuantity($dto->getQuantity())
            ->setOrder($order)
            ->setPastry($pastry)
            ->setFormat($format);

        $this->orderPastriesManager->save($orderPastries);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);

    }

}
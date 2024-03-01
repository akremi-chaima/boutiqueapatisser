<?php

namespace App\Controller\Pastry;

use App\DTO\Pastry\PastriesFilterDTO;
use App\Manager\PastryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetPastriesByFilterController extends AbstractController
{
    /** @var PastryManager */
    private $pastryManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param PastryManager $pastryManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PastryManager $pastryManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->pastryManager = $pastryManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Get pastries list by filter
     *
     * @Route("/api/pastries/{page}/{itemsPerPage}", methods={"POST"})
     *
     * @OA\Tag(name="Pastries")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="price", type="float"),
     *              @OA\Property(property="categoryId", type="integer"),
     *              @OA\Property(property="subCollectionId", type="integer"),
     *              @OA\Property(property="collectionId", type="integer"),
     *              @OA\Property(property="flavourId", type="integer"),
     *              @OA\Property(property="orderBy", type="string"),
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Filtred pastries list")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request,  int $page, int $itemsPerPage): JsonResponse
    {
        /** @var PastriesFilterDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), PastriesFilterDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }


        $pastriesTotalNumber = $this->pastryManager->count($dto);
        $pastriesPaginator = $this->pastryManager->get($dto, $page, $itemsPerPage);
        $result = [
            'data' => json_decode($this->serializer->serialize($pastriesPaginator->getItems(), 'json'), true),
            'currentPage' => $page,
            'totalItems' => $pastriesTotalNumber,
        ];
        return new JsonResponse($result, Response::HTTP_OK);
    }
}
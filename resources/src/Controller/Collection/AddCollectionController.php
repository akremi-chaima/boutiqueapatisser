<?php

namespace App\Controller\Collection;

use App\DTO\Collection\AddCollectionDTO;
use App\DTO\Collection\UpdateCollectionDTO;
use App\Entity\Collection;
use App\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddCollectionController extends AbstractController
{
    /* @var CollectionManager */
    private $collectionManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param CollectionManager $collectionManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        CollectionManager $collectionManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->collectionManager = $collectionManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Add collection
     *
     * @Route("/api/add/collection", methods={"POST"})
     *
     * @OA\Tag(name="Collections")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"name", "isActive"},
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="isActive", type="boolean"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Collection added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var AddCollectionDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddCollectionDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $collection = (new Collection())
            ->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->collectionManager->save($collection);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
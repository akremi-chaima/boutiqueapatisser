<?php

namespace App\Controller\SubCollection;

use App\DTO\SubCollection\UpdateSubCollectionDTO;
use App\Manager\CollectionManager;
use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateSubCollectionController extends AbstractController
{
    /* @var CollectionManager */
    private $collectionManager;

    /* @var SubCollectionManager */
    private $subCollectionManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param CollectionManager $collectionManager
     * @param SubCollectionManager $subCollectionManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        CollectionManager $collectionManager,
        SubCollectionManager $subCollectionManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->collectionManager = $collectionManager;
        $this->subCollectionManager = $subCollectionManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update collection
     *
     * @Route("/api/update/sub/collection", methods={"PUT"})
     *
     * @OA\Tag(name="SubCollections")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "isActive", "collectionId"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="isActive", type="boolean"),
     *              @OA\Property(property="collectionId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Collection updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateSubCollectionDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateSubCollectionDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $collection = $this->collectionManager->findOneBy(['id' => $dto->getCollectionId()]);
        if (is_null($collection)) {
            return new JsonResponse(['error_message' => 'The collection is not found'], Response::HTTP_BAD_REQUEST);
        }
        $subCollection = $this->subCollectionManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($subCollection)) {
            return new JsonResponse(['error_message' => 'The subCollection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $subCollection->setName($dto->getName())
            ->setIsActive($dto->getIsActive())
            ->setCollection($collection);

        $this->subCollectionManager->save($subCollection);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
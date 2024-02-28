<?php

namespace App\Controller\SubCollection;

use App\DTO\SubCollection\AddSubCollectionDTO;
use App\DTO\SubCollection\UpdateSubCollectionDTO;
use App\Entity\SubCollection;
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

class AddSubCollectionController extends AbstractController
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
     * Update subCollection
     *
     * @Route("/api/add/sub/collection", methods={"POST"})
     *
     * @OA\Tag(name="SubCollections")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"name", "isActive", "collectionId"},
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
        /** @var AddSubCollectionDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddSubCollectionDTO::class, 'json');

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

        $subCollection = (new SubCollection())
            ->setName($dto->getName())
            ->setIsActive($dto->getIsActive())
            ->setCollection($collection);

        $this->subCollectionManager->save($subCollection);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
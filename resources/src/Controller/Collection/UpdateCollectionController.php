<?php

namespace App\Controller\Collection;

use App\DTO\Collection\UpdateCollectionDTO;
use App\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCollectionController extends AbstractController
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
     * Update collection
     *
     * @Route("/api/update/collection", methods={"PUT"})
     *
     * @OA\Tag(name="Collections")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "isActive"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="isActive", type="boolean"),
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
        /** @var UpdateCollectionDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateCollectionDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $collection = $this->collectionManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($collection)) {
            return new JsonResponse(['error_message' => 'The collection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $collection->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->collectionManager->save($collection);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
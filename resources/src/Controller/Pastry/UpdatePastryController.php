<?php

namespace App\Controller\Pastry;

use App\DTO\Pastry\UpdatePastryDTO;
use App\Manager\CategoryManager;
use App\Manager\FlavourManager;
use App\Manager\PastryManager;
use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdatePastryController extends AbstractController
{
    /** @var FlavourManager  */
    private $flavourManager;

    /** @var CategoryManager */
    private $categoryManager;

    /** @var SubCollectionManager */
    private $subCollectionManager;

    /** @var PastryManager */
    private $pastryManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param FlavourManager $flavourManager
     * @param CategoryManager $categoryManager
     * @param SubCollectionManager $subCollectionManager
     * @param PastryManager $pastryManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        FlavourManager $flavourManager,
        CategoryManager $categoryManager,
        SubCollectionManager $subCollectionManager,
        PastryManager $pastryManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->flavourManager = $flavourManager;
        $this->categoryManager = $categoryManager;
        $this->subCollectionManager = $subCollectionManager;
        $this->pastryManager = $pastryManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update pastry
     *
     * @Route("/api/update/pastry", methods={"PUT"})
     *
     * @OA\Tag(name="Pastries")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "price", "descripion", "isVisible", "categoryId", "subCollectionId", "flavourId"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="price", type="float"),
     *              @OA\Property(property="descripion", type="string"),
     *              @OA\Property(property="isVisible", type="boolean"),
     *              @OA\Property(property="categoryId", type="integer"),
     *              @OA\Property(property="subCollectionId", type="integer"),
     *              @OA\Property(property="flavourId", type="integer"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Pastry updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdatePastryDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdatePastryDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $flavour = $this->flavourManager->findOneBy(['id' => $dto->getFlavourId()]);
        if (is_null($flavour)) {
            return new JsonResponse(['error_message' => 'The flavour is not found'], Response::HTTP_BAD_REQUEST);
        }

        $category = $this->categoryManager->findOneBy(['id' => $dto->getCategoryId()]);
        if (is_null($category)) {
            return new JsonResponse(['error_message' => 'The category is not found'], Response::HTTP_BAD_REQUEST);
        }

        $subCollection = $this->subCollectionManager->findOneBy(['id' => $dto->getSubCollectionId()]);
        if (is_null($subCollection)) {
            return new JsonResponse(['error_message' => 'The subCollection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $pastry = $this->pastryManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($pastry)) {
            return new JsonResponse(['error_message' => 'The pastry is not found'], Response::HTTP_BAD_REQUEST);
        }

        $pastry->setName($dto->getName())
            ->setPrice($dto->getPrice())
            ->setDescription($dto->getDescription())
            ->setIsVisible($dto->getIsVisible())
            ->setCategory($category)
            ->setSubCollection($subCollection)
            ->setFlavour($flavour);

        $this->pastryManager->save($pastry);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
<?php

namespace App\Controller\Category;

use App\DTO\Category\UpdateCategoryDTO;
use App\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCategoryController extends AbstractController
{
    /* @var CategoryManager */
    private $categoryManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param CategoryManager $categoryManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        CategoryManager $categoryManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->categoryManager = $categoryManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update collection
     *
     * @Route("/api/update/category", methods={"PUT"})
     *
     * @OA\Tag(name="Categories")
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
     * @OA\Response(response=200, description="Category updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateCategoryDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateCategoryDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $category = $this->categoryManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($category)) {
            return new JsonResponse(['error_message' => 'The collection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $category->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->categoryManager->save($category);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
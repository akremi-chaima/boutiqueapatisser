<?php

namespace App\Controller\Category;

use App\DTO\Category\AddCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Entity\Category;
use App\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddCategoryController extends AbstractController
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
     * Add collection
     *
     * @Route("/api/add/category", methods={"POST"})
     *
     * @OA\Tag(name="Categories")
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
     * @OA\Response(response=200, description="Category added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var AddCategoryDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddCategoryDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $category = (new Category())
            ->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->categoryManager->save($category);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
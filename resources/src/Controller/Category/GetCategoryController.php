<?php

namespace App\Controller\Category;

use App\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetCategoryController extends AbstractController
{
    /* @var CategoryManager */
    private $categoryManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param CategoryManager $categoryManager
     * @param SerializerInterface $serializer
     */
    public function __construct(CategoryManager $categoryManager, SerializerInterface $serializer)
    {
        $this->categoryManager = $categoryManager;
        $this->serializer = $serializer;
    }

    /**
     * Get category by id
     *
     * @Route("/api/category/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Categories")
     *
     * @OA\Response(response=200, description="Category")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $category = $this->categoryManager->findOneBy(['id' => $id]);
        if(is_null($category)){
            return new JsonResponse(['error_message' => 'The category is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode($this->serializer->serialize($category, 'json'), true), Response::HTTP_OK);
    }

}
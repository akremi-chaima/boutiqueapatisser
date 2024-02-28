<?php

namespace App\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Manager\CategoryManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetCategoriesController extends AbstractController
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
     * Get categories list
     *
     * @Route("/api/categories", methods={"GET"})
     *
     * @OA\Tag(name="Categories")
     *
     * @OA\Response(response=200, description="Categories list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $categories = $this->categoryManager->findAll();
        $normalizedList = $this->serializer->serialize($categories, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
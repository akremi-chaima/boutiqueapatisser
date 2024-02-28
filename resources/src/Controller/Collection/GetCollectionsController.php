<?php

namespace App\Controller\Collection;

use App\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetCollectionsController extends AbstractController
{
    /* @var CollectionManager */
    private $collectionManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param CollectionManager $collectionManager
     * @param SerializerInterface $serializer
     */
    public function __construct(CollectionManager $collectionManager, SerializerInterface $serializer)
    {
        $this->collectionManager = $collectionManager;
        $this->serializer = $serializer;
    }

    /**
     * Get collections list
     *
     * @Route("/api/collections", methods={"GET"})
     *
     * @OA\Tag(name="Collections")
     *
     * @OA\Response(response=200, description="Collections list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $collections = $this->collectionManager->findAll();
        $normalizedList = $this->serializer->serialize($collections, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
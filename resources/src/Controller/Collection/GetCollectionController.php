<?php

namespace App\Controller\Collection;

use App\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetCollectionController extends AbstractController
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
     * Get collection by id
     *
     * @Route("/api/collection/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Collections")
     *
     * @OA\Response(response=200, description="Collection")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $collection = $this->collectionManager->findOneBy(['id' => $id]);
        if(is_null($collection)){
            return new JsonResponse(['error_message' => 'The collection is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode( $this->serializer->serialize($collection, 'json'), true), Response::HTTP_OK);
    }

}
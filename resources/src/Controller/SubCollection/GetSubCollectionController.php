<?php

namespace App\Controller\SubCollection;

use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetSubCollectionController extends AbstractController
{
    /* @var SubCollectionManager */
    private $subCollectionManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param SubCollectionManager $subCollectionManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SubCollectionManager $subCollectionManager,
        SerializerInterface $serializer
    )
    {
        $this->subCollectionManager = $subCollectionManager;
        $this->serializer = $serializer;
    }

    /**
     * Get subCollection by id
     *
     * @Route("/api/sub/collection/{id}", methods={"GET"})
     *
     * @OA\Tag(name="SubCollections")
     *
     * @OA\Response(response=200, description="SubCollection")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $subCollection = $this->subCollectionManager->findOneBy(['id' => $id]);
        if(is_null($subCollection)){
            return new JsonResponse(['error_message' => 'The collection is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode( $this->serializer->serialize($subCollection, 'json'), true), Response::HTTP_OK);
    }

}
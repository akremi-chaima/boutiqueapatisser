<?php

namespace App\Controller\SubCollection;

use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetSubCollectionsController extends AbstractController
{
    /* @var SubCollectionManager */
    private $subCollectionManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param SubCollectionManager $subCollectionManager
     * @param SerializerInterface $serializer
     */
    public function __construct(SubCollectionManager $subCollectionManager, SerializerInterface $serializer)
    {
        $this->subCollectionManager = $subCollectionManager;
        $this->serializer = $serializer;
    }

    /**
     * Get subCollections list
     *
     * @Route("/api/sub/collections", methods={"GET"})
     *
     * @OA\Tag(name="SubCollections")
     *
     * @OA\Response(response=200, description="SubCollections list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $subCollections = $this->subCollectionManager->findAll();
        $normalizedList = $this->serializer->serialize($subCollections, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
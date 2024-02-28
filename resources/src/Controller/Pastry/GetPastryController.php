<?php

namespace App\Controller\Pastry;

use App\Manager\PastryManager;
use App\Manager\PictureManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class GetPastryController extends AbstractController
{
    /** @var PastryManager  */
    private $pastryManager;

    /** @var SerializerInterface */
    private $serializer;


    /**
     * @param PastryManager $pastryManager
     * @param SerializerInterface $serializer
     */
    public function __construct(PastryManager $pastryManager,SerializerInterface $serializer)
    {
        $this->pastryManager = $pastryManager;
        $this->serializer = $serializer;
    }

    /**
     * Get pastry by id
     *
     * @Route("/api/pastry/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Pastries")
     *
     * @OA\Response(response=200, description="Pastry")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $pastry = $this->pastryManager->findOneBy(['id' => $id]);
        if (is_null($pastry)) {
            return new JsonResponse(['error_message' => 'The pastry is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode($this->serializer->serialize($pastry, 'json'), true), Response::HTTP_OK);
    }
}
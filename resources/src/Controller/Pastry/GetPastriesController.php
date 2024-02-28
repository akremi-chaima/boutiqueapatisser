<?php

namespace App\Controller\Pastry;

use App\Manager\PastryManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


class GetPastriesController extends AbstractController
{
    /** @var PastryManager  */
    private $pastryManager;

    /** @var SerializerInterface */
    private $serializer;


    /**
     * @param PastryManager $pastryManager
     * @param SerializerInterface $serializer
     */
    public function __construct(PastryManager $pastryManager, SerializerInterface $serializer)
    {
        $this->pastryManager = $pastryManager;
        $this->serializer = $serializer;
    }

    /**
     * Get pastries list
     *
     * @Route("/api/pastries", methods={"GET"})
     *
     * @OA\Tag(name="Pastries")
     *
     * @OA\Response(response=200, description="Pastries list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $pastries = $this->pastryManager->findAll();
        $normalizedList = $this->serializer->serialize($pastries, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }
}
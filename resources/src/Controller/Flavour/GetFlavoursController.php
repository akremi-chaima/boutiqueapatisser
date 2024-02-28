<?php

namespace App\Controller\Flavour;

use App\Manager\FlavourManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetFlavoursController extends AbstractController
{
    /** @var FlavourManager  */
    private $flavourManager;

    /** @var SerializerInterface */
    private $serializer;


    /**
     * @param FlavourManager $flavourManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        FlavourManager $flavourManager,
        SerializerInterface $serializer
    )
    {
        $this->flavourManager = $flavourManager;
        $this->serializer = $serializer;
    }

    /**
     * Get flavours list
     *
     * @Route("/api/flavours", methods={"GET"})
     *
     * @OA\Tag(name="Flavours")
     *
     * @OA\Response(response=200, description="Flavours list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $flavours = $this->flavourManager->findAll();
        $normalizedList = $this->serializer->serialize($flavours, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}
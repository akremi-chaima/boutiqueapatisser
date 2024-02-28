<?php

namespace App\Controller\Flavour;

use App\Manager\FlavourManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetFlavourController extends AbstractController
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
     * Get flavour by id
     *
     * @Route("/api/flavour/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Flavours")
     *
     * @OA\Response(response=200, description="Flavour")
     *
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $flavour = $this->flavourManager->findOneBy(['id' => $id]);
        if (is_null($flavour)) {
            return new JsonResponse(['error_message' => 'The flavour is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode($this->serializer->serialize($flavour, 'json'), true), Response::HTTP_OK);
    }

}
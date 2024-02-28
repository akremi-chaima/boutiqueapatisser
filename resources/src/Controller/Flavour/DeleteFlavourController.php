<?php

namespace App\Controller\Flavour;

use App\Manager\FlavourManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class DeleteFlavourController extends AbstractController
{
    /** @var FlavourManager  */
    private $flavourManager;

    /**
     * @param FlavourManager $flavourManager
     */
    public function __construct(FlavourManager $flavourManager)
    {
        $this->flavourManager = $flavourManager;
    }

    /**
     * Delete flavour
     *
     * @Route("/api/delete/flavour/{id}", methods={"DELETE"})
     *
     * @OA\Tag(name="Flavours")
     *
     * @OA\Response(response=200, description="Flavour deleted")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $flavour = $this->flavourManager->findOneBy(['id' => $id]);
        if (is_null($flavour)) {
            return new JsonResponse(['error_message' => 'The flavour is not found'], Response::HTTP_BAD_REQUEST);
        }
        $this->flavourManager->delete($flavour);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
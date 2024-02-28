<?php

namespace App\Controller\Pastry;

use App\Manager\PastryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class DeletePastryController extends AbstractController
{
    /** @var PastryManager  */
    private $pastryManager;

    /**
     * @param PastryManager $pastryManager
     */
    public function __construct(PastryManager $pastryManager)
    {
        $this->pastryManager = $pastryManager;
    }

    /**
     * Delete pastry
     *
     * @Route("/api/delete/pastry/{id}", methods={"DELETE"})
     *
     * @OA\Tag(name="Pastries")
     *
     * @OA\Response(response=200, description="Pastry deleted")
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
        $this->pastryManager->delete($pastry);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
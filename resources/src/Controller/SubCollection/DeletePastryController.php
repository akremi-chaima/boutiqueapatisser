<?php

namespace App\Controller\SubCollection;

use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class DeletePastryController extends AbstractController
{
    /* @var SubCollectionManager */
    private $subCollectionManager;

    /**
     * @param SubCollectionManager $subCollectionManager
     */
    public function __construct(SubCollectionManager $subCollectionManager)
    {
        $this->subCollectionManager = $subCollectionManager;
    }

    /**
     * Delete subCollection
     *
     * @Route("/api/delete/sub/collection/{id}", methods={"DELETE"})
     *
     * @OA\Tag(name="SubCollections")
     *
     * @OA\Response(response=200, description="SubCollection deleted")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $subCollection = $this->subCollectionManager->findOneBy(['id' => $id]);
        if (is_null($subCollection)) {
            return new JsonResponse(['error_message' => 'The sub collection is not found'], Response::HTTP_BAD_REQUEST);
        }
        $this->subCollectionManager->delete($subCollection);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}
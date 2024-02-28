<?php

namespace App\Controller\User;

use App\Manager\PastryManager;
use App\Manager\PictureManager;
use App\Manager\UserManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
class GetUserController extends AbstractController
{
    /** @var UserManager  */
    private $userManager;

    /** @var SerializerInterface */
    private $serializer;


    /**
     * @param UserManager $pastryManager
     * @param SerializerInterface $serializer
     */
    public function __construct(UserManager $userManager, SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->serializer = $serializer;
    }

    /**
     * Get user by id
     *
     * @Route("/api/user/{id}", methods={"GET"})
     *
     * @OA\Tag(name="Users")
     *
     * @OA\Response(response=200, description="User")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $user = $this->userManager->findOneBy(['id' => $id]);
        if (is_null($user)) {
            return new JsonResponse(['error_message' => 'The user is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode($this->serializer->serialize($user, 'json'), true), Response::HTTP_OK);
    }
}
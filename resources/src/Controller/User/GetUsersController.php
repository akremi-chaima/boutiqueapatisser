<?php

namespace App\Controller\User;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetUsersController extends AbstractController
{
    /* @var UserManager */
    private $userManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param UserManager $userManager
     * @param SerializerInterface $serializer
     */
    public function __construct(UserManager $userManager, SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->serializer = $serializer;
    }

    /**
     * Get roles list
     *
     * @Route("/api/users", methods={"GET"})
     *
     * @OA\Tag(name="Users")
     *
     * @OA\Response(response=200, description="Users list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $users = $this->userManager->findAll();
        $normalizedList = $this->serializer->serialize($users, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}